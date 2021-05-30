<?php


namespace booking\services\shops;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\funs\WorkMode;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\entities\Meta;
use booking\entities\shops\Delivery;
use booking\entities\shops\InfoAddress;
use booking\entities\shops\order\Order;
use booking\entities\shops\Photo;
use booking\entities\shops\ReviewShop;
use booking\entities\shops\Shop;
use booking\forms\booking\ReviewForm;
use booking\forms\MetaForm;
use booking\forms\WorkModeForm;
use booking\forms\shops\ShopCreateForm;
use booking\helpers\scr;
use booking\helpers\StatusHelper;
use booking\repositories\message\DialogRepository;
use booking\repositories\shops\ReviewShopRepository;
use booking\repositories\shops\ShopRepository;
use booking\services\ContactService;
use booking\services\ImageService;
use booking\services\system\LoginService;

class ShopService
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
     * @var ReviewShopRepository
     */
    private $reviews;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        ShopRepository $shops,
        ContactService $contactService,
        DialogRepository $dialogs,
        ReviewShopRepository $reviews,
        LoginService $loginService
    )
    {
        $this->shops = $shops;
        $this->contactService = $contactService;
        $this->dialogs = $dialogs;
        $this->reviews = $reviews;
        $this->loginService = $loginService;
    }

    public function create(ShopCreateForm $form): Shop
    {
        $shop = Shop::create(
            $this->loginService->admin()->getId(),
            $form->legal_id,
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->type_id,
            $form->ad
        );

        $this->update($shop, $form);
        //scr::p($form->categoriesAssign);
        foreach ($form->categoriesAssign as $assign)
        {
            $shop->assignCategory($assign);
        }

        $this->shops->save($shop);
        return $shop;
    }

    public function edit(int $id, ShopCreateForm $form): void
    {
        $shop = $this->shops->get($id);
        $shop->contactAssign = [];
        $shop->addresses = [];
        $shop->clearCategory();
        $this->shops->save($shop);

        if ($shop->ad != $form->ad) {
            foreach ($shop->products as $product) {
                $product->draft();
                $product->save();
            }
        }
        $shop->edit(
            $form->legal_id,
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->type_id,
            $form->ad
        );

        $this->update($shop, $form);
        foreach ($form->categoriesAssign as $assign)
        {
            $shop->assignCategory($assign);
        }
        $this->shops->save($shop);
    }

    private function update(Shop $shop, ShopCreateForm $form)
    {
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
                $shop->addPhoto(Photo::create($file));
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
            $shop->addAddress(InfoAddress::create(
                $addressForm->phone,
                $addressForm->city,
                $addressForm->address,
                $addressForm->latitude,
                $addressForm->longitude,
                ));
        }
        //Delivery
        //if (!$shop->isAd()) $shop->setDelivery($form->delivery);
        //if (count($form->delivery->deliveryCompany) != 0)
        $shop->setDelivery($form->delivery);
    }

    public function verify($id)
    {
        $shop = $this->shops->get($id);
        if (!$shop->isInactive())
            throw new \DomainException('Нельзя отправить на модерацию');

        $shop->setStatus(StatusHelper::STATUS_VERIFY);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            $this->loginService->admin()->getId(),
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation(Shop::class . ' ID=' . $shop->id . '&' . 'STATUS=' . StatusHelper::STATUS_VERIFY);
        $this->dialogs->save($dialog);
        $this->contactService->sendActivate($shop->name, $shop->user->username);
        $this->shops->save($shop);
    }

    public function cancel(int $id)
    {
        $shop = $this->shops->get($id);
        if (!$shop->isVerify())
            throw new \DomainException('Нельзя отменить');
        $shop->setStatus(StatusHelper::STATUS_INACTIVE);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            $this->loginService->admin()->getId(),
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
        $shop = $this->shops->get($id);
        if (!$shop->isActive())
            throw new \DomainException('Нельзя отправить в черновики');
        $shop->setStatus(StatusHelper::STATUS_DRAFT);
        $this->shops->save($shop);
        //Дезактивируем товары
        foreach ($shop->products as $product) {
            $product->draft();
            $product->save();
        }
    }

    public function activate(int $id)
    {
        $shop = $this->shops->get($id);
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
        $shop = $this->shops->get($id);
        $shop->setStatus(StatusHelper::STATUS_LOCK);
        $this->shops->save($shop);
        $this->contactService->sendLockShop($shop);
    }

    public function unlock(int $id)
    {
        $shop = $this->shops->get($id);
        if (!$shop->isLock())
            throw new \DomainException('Нельзя разблокировать');
        $shop->setStatus(StatusHelper::STATUS_INACTIVE);
        $this->shops->save($shop);
    }

    public function setActivePlace(int $id, int $count)
    {
        $shop = $this->shops->get($id);
        $shop->setActivePlace($count);
        $this->shops->save($shop);
    }

    public function setFreeProducts(int $id, int $count)
    {
        $shop = $this->shops->get($id);
        $shop->setFreeProducts($count);
        $this->shops->save($shop);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $shop = $this->shops->get($id);
        $shop->movePhotoUp($photoId);
        $this->shops->save($shop);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $shop = $this->shops->get($id);
        $shop->movePhotoDown($photoId);
        $this->shops->save($shop);
    }

    public function removePhoto($id, $photoId): void
    {
        $shop = $this->shops->get($id);
        $shop->removePhoto($photoId);
        $this->shops->save($shop);
    }

    public function addReview($shop_id, $user_id, ReviewForm $form)
    {
        $product = $this->shops->get($shop_id);
        $review = $product->addReview(ReviewShop::create($user_id, $form->vote, $form->text));
        $this->shops->save($product);
        $this->contactService->sendNoticeReview($review);
    }

    public function removeReview($review_id)
    {
        $review = $this->reviews->get($review_id);
        $shop = $this->shops->get($review->shop_id);
        $shop->removeReview($review_id);
        $this->shops->save($shop);
    }

    public function editReview($review_id, ReviewForm $form)
    {
        $review = $this->reviews->get($review_id);
        $shop = $this->shops->get($review->shop_id);
        $shop->editReview($review_id, $form->vote, $form->text);
        $this->shops->save($shop);
    }

    public function remove($id)
    {
        $shop = $this->shops->get($id);
        $orders = Order::find()->andWhere(['shop_id' => $id])->count();
        if ($orders > 0) throw new \DomainException('Нельзя удалить магазин, товары которого находятся в заказе! Отправьте его в черновик');
        $this->shops->remove($shop);
    }

    public function setMeta($id, MetaForm $form)
    {
        $shop = $this->shops->get($id);
        $shop->setMeta(new Meta($form->title, $form->description, $form->keywords));
        $this->shops->save($shop);
    }
}