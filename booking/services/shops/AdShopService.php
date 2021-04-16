<?php


namespace booking\services\shops;


use booking\entities\booking\funs\WorkMode;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\entities\shops\AdInfoAddress;
use booking\entities\shops\AdPhoto;
use booking\entities\shops\AdReviewShop;
use booking\entities\shops\AdShop;
use booking\forms\booking\funs\WorkModeForm;
use booking\forms\booking\ReviewForm;
use booking\forms\shops\ShopAdCreateForm;
use booking\helpers\StatusHelper;
use booking\repositories\message\DialogRepository;
use booking\repositories\shops\AdReviewRepository;
use booking\repositories\shops\ShopRepository;
use booking\services\ContactService;
use booking\services\ImageService;

class AdShopService
{
    /**
     * @var ShopRepository
     */
    private $shops;
    /**
     * @var ContactService
     */
    private $contactService;
    /**
     * @var DialogRepository
     */
    private $dialogs;
    /**
     * @var AdReviewRepository
     */
    private $reviews;

    public function __construct(
        ShopRepository $shops,
        ContactService $contactService,
        DialogRepository $dialogs,
        AdReviewRepository $reviews

    )
    {
        $this->shops = $shops;
        $this->contactService = $contactService;
        $this->dialogs = $dialogs;
        $this->reviews = $reviews;
    }

    public function create(ShopAdCreateForm $form): AdShop
    {
        $shop = AdShop::create(
            \Yii::$app->user->id,
            $form->legal_id,
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->type_id
        );

        $shop->setWorkMode(array_map(function (WorkModeForm $modeForm) {
            return new WorkMode(
                $modeForm->day_begin,
                $modeForm->day_end,
                $modeForm->break_begin,
                $modeForm->break_end
            );
        }, $form->workModes));

        //Photo
        if ($form->photos->files != null)
            foreach ($form->photos->files as $file) {
                $shop->addPhoto(AdPhoto::create($file));
                ImageService::rotate($file->tempName);
            }
        //Contact
        //scr::_v(count($form->contactAssign));
        foreach ($form->contactAssign as $assignForm) {
            $shop->addContact(
                $assignForm->_contact->id,
                $assignForm->value,
                $assignForm->description
            );
        }
        //Addresses
        foreach ($form->addresses as $addressForm) {
            $shop->addAddress(AdInfoAddress::create(
                $addressForm->phone,
                $addressForm->city,
                $addressForm->address,
                $addressForm->latitude,
                $addressForm->longitude,
                ));
        }

        ini_set('max_execution_time', 180);
        $this->shops->save($shop);
        ini_set('max_execution_time', 30);
        return $shop;
    }

    public function edit(int $id, ShopAdCreateForm $form): void
    {
        $shop = $this->shops->getAd($id);

        $shop->contactAssign = [];
        $shop->addresses = [];
        $this->shops->save($shop);

        $shop->edit(
            $form->legal_id,
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->type_id
        );
        $shop->setWorkMode(array_map(function (WorkModeForm $modeForm) {
            return new WorkMode(
                $modeForm->day_begin,
                $modeForm->day_end,
                $modeForm->break_begin,
                $modeForm->break_end
            );
        }, $form->workModes));
        //Photo
        if ($form->photos->files != null)
            foreach ($form->photos->files as $file) {
                $shop->addPhoto(AdPhoto::create($file));
                ImageService::rotate($file->tempName);
            }
        //Contact
        foreach ($form->contactAssign as $assignForm) {
            $shop->addContact(
                $assignForm->_contact->id,
                $assignForm->value,
                $assignForm->description
            );
        }
        //Addresses
        foreach ($form->addresses as $addressForm) {
            $shop->addAddress(AdInfoAddress::create(
                $addressForm->phone,
                $addressForm->city,
                $addressForm->address,
                $addressForm->latitude,
                $addressForm->longitude,
                ));
        }
        $this->shops->save($shop);
    }

    public function verify($id)
    {
        $shop = $this->shops->getAd($id);
        if (!$shop->isInactive())
            throw new \DomainException('Нельзя отправить на модерацию');

        $shop->setStatus(StatusHelper::STATUS_VERIFY);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            \Yii::$app->user->id,
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation(AdShop::class . ' ID=' . $shop->id . '&' . 'STATUS=' . StatusHelper::STATUS_VERIFY);
        $this->dialogs->save($dialog);
        $this->contactService->sendActivate($shop->name, $shop->user->username);
        $this->shops->save($shop);
    }

    public function cancel(int $id)
    {
        $shop = $this->shops->getAd($id);
        if (!$shop->isVerify())
            throw new \DomainException('Нельзя отменить');
        $shop->setStatus(StatusHelper::STATUS_INACTIVE);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            \Yii::$app->user->id,
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation('ID=' . $shop->id . '&' . 'STATUS=' . StatusHelper::STATUS_INACTIVE);
        $this->dialogs->save($dialog);
        $this->contactService->sendNoticeMessage($dialog);
        $this->shops->save($shop);
    }

    public function draft(int $id)
    {
        $shop = $this->shops->getAd($id);
        if (!$shop->isActive())
            throw new \DomainException('Нельзя отправить в черновики');
        $shop->setStatus(StatusHelper::STATUS_DRAFT);
        $this->shops->save($shop);
    }

    public function activate(int $id)
    {
        $shop = $this->shops->getAd($id);
        //Активировать можно только из Черновика, или с Модерации
        if ($shop->isDraft() || $shop->isVerify()) {
            if ($shop->isVerify()) $shop->public_at = time(); //Фиксируем дату публикации
            $shop->setStatus(StatusHelper::STATUS_ACTIVE);
            $this->shops->save($shop);
        } else {
            throw new \DomainException('Нельзя активировать');
        }
    }

    public function lock(int $id)
    {
        $shop = $this->shops->getAd($id);
        $shop->setStatus(StatusHelper::STATUS_LOCK);
        $this->shops->save($shop);
        $this->contactService->sendLockShop($shop);
    }

    public function unlock(int $id)
    {
        $shop = $this->shops->getAd($id);
        if (!$shop->isLock())
            throw new \DomainException('Нельзя разблокировать');
        $shop->setStatus(StatusHelper::STATUS_INACTIVE);
        $this->shops->save($shop);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $shop = $this->shops->getAd($id);
        $shop->movePhotoUp($photoId);
        $this->shops->save($shop);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $shop = $this->shops->getAd($id);
        $shop->movePhotoDown($photoId);
        $this->shops->save($shop);
    }

    public function removePhoto($id, $photoId): void
    {
        $shop = $this->shops->getAd($id);
        $shop->removePhoto($photoId);
        $this->shops->save($shop);
    }

    public function addReview($tour_id, $user_id, ReviewForm $form)
    {
        $shop = $this->shops->getAd($tour_id);
        $review = $shop->addReview(AdReviewShop::create($user_id, $form->vote, $form->text));
        $this->shops->save($shop);
        $this->contactService->sendNoticeReview($review);
    }

    public function removeReview($review_id)
    {
        $review = $this->reviews->get($review_id);
        $shop = $this->shops->getAd($review->shop_id);
        $shop->removeReview($review_id);
        $this->shops->save($shop);
    }

    public function editReview($review_id, ReviewForm $form)
    {
        $review = $this->reviews->get($review_id);
        $shop = $this->shops->getAd($review->shop_id);
        $shop->editReview($review_id, $form->vote, $form->text);
        $this->shops->save($shop);
    }
}