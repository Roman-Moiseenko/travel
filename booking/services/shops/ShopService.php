<?php


namespace booking\services\shops;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\funs\WorkMode;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\entities\shops\Delivery;
use booking\entities\shops\InfoAddress;
use booking\entities\shops\Photo;
use booking\entities\shops\Shop;
use booking\forms\WorkModeForm;
use booking\forms\shops\ShopCreateForm;
use booking\helpers\scr;
use booking\helpers\StatusHelper;
use booking\repositories\message\DialogRepository;
use booking\repositories\shops\ShopRepository;
use booking\services\ContactService;
use booking\services\ImageService;

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

    public function __construct(
        ShopRepository $shops,
        ContactService $contactService,
        DialogRepository $dialogs
    )
    {
        $this->shops = $shops;
        $this->contactService = $contactService;
        $this->dialogs = $dialogs;
    }

    public function create(ShopCreateForm $form): Shop
    {
        $shop = Shop::create(
            \Yii::$app->user->id,
            $form->legal_id,
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->type_id,
            $form->ad
        );

        $this->update($shop, $form);

        $this->shops->save($shop);
        return $shop;
    }

    public function edit(int $id, ShopCreateForm $form): void
    {
        $shop = $this->shops->get($id);
        $shop->contactAssign = [];
        $shop->addresses = [];
        $this->shops->save($shop);

        if ($shop->ad !== $form->ad) {
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
        $shop->setDelivery(Delivery::create(
            $form->delivery->onCity,
            $form->delivery->costCity,
            $form->delivery->minAmountCity,
            $form->delivery->minAmountCompany,
            $form->delivery->period,
            $form->delivery->deliveryCompany,
            $form->delivery->onPoint,
            new BookingAddress(
                $form->delivery->addressPoint->address,
                $form->delivery->addressPoint->latitude,
                $form->delivery->addressPoint->longitude
            )
        ));
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
            \Yii::$app->user->id,
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
        $shop = $this->shops->get($id);
        if (!$shop->isActive())
            throw new \DomainException('Нельзя отправить в черновики');
        $shop->setStatus(StatusHelper::STATUS_DRAFT);
        $this->shops->save($shop);
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

}