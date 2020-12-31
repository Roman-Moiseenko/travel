<?php

namespace booking\services\booking\cars;

use booking\entities\booking\AgeLimit;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\cars\Car;
use booking\entities\booking\cars\CarParams;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\forms\booking\cars\CarCommonForm;
use booking\forms\booking\cars\CarFinanceForm;
use booking\forms\booking\cars\CarParamsForm;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\helpers\StatusHelper;
use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\cars\CostCalendarRepository;
use booking\repositories\booking\cars\ExtraRepository;
use booking\repositories\booking\cars\ReviewCarRepository;
use booking\repositories\booking\cars\TypeRepository;
use booking\repositories\message\DialogRepository;
use booking\services\ContactService;
use booking\services\ImageService;
use booking\services\TransactionManager;

class CarService
{


    /**
     * @var CarRepository
     */
    private $cars;
    /**
     * @var TransactionManager
     */
    private $transaction;
    /**
     * @var TypeRepository
     */
    private $types;
    /**
     * @var ExtraRepository
     */
    private $extra;
    /**
     * @var ContactService
     */
    private $contactService;
    /**
     * @var ReviewCarRepository
     */
    private $reviews;
    /**
     * @var DialogRepository
     */
    private $dialogs;
    /**
     * @var CostCalendarRepository
     */
    private $calendars;

    public function __construct(
        CarRepository $cars,
        TransactionManager $transaction,
        TypeRepository $types,
        ExtraRepository $extra,
        ContactService $contactService,
        ReviewCarRepository $reviews,
        DialogRepository $dialogs,
        CostCalendarRepository $calendars
    )
    {
        $this->cars = $cars;
        $this->transaction = $transaction;
        $this->types = $types;
        $this->extra = $extra;
        $this->contactService = $contactService;
        $this->reviews = $reviews;
        $this->dialogs = $dialogs;
        $this->calendars = $calendars;
    }

    public function create(CarCommonForm $form): Car
    {
        $car = Car::create(
            $form->name,
            $form->name_en,
            $form->type_id,
            $form->description,
            $form->description_en,
            $form->year
        );
        foreach ($form->cities->cities as $city) {
            $car->assignCity($city);
        }

        $this->cars->save($car);
        return $car;
    }

    public function edit($id, CarCommonForm $form): void
    {
        $car = $this->cars->get($id);
        if ($car->type_id != $form->type_id) {
            $car->clearValues();
        }
        $car->edit(
            $form->name,
            $form->name_en,
            $form->type_id,
            $form->description,
            $form->description_en,
            $form->year
        );
        $car->revokeCities();
        $this->cars->save($car);
        foreach ($form->cities->cities as $city) {
            $car->assignCity($city);
        }
        $this->cars->save($car);
    }

    public function addPhotos($id, PhotosForm $form)
    {
        $car = $this->cars->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $car->addPhoto($file);
                ImageService::rotate($file->tempName);
            }
        ini_set('max_execution_time', 180);
        $this->cars->save($car);
        ini_set('max_execution_time', 30);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $car = $this->cars->get($id);
        $car->movePhotoUp($photoId);
        $this->cars->save($car);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $car = $this->cars->get($id);
        $car->movePhotoDown($photoId);
        $this->cars->save($car);
    }

    public function removePhoto($id, $photoId): void
    {
        $car = $this->cars->get($id);
        $car->removePhoto($photoId);
        $this->cars->save($car);
    }

    public function addReview($car_id, $user_id, ReviewForm $form)
    {
        $car = $this->cars->get($car_id);
        $review = $car->addReview($user_id, $form->vote, $form->text);
        $this->cars->save($car);
        $this->contactService->sendNoticeReview($review);
    }

    public function removeReview($review_id)
    {
        $review = $this->reviews->get($review_id);
        $car = $this->cars->get($review->car_id);
        $car->removeReview($review_id);
        $this->cars->save($car);
    }

    public function editReview($review_id, ReviewForm $form)
    {
        $review = $this->reviews->get($review_id);
        $car = $this->cars->get($review->car_id);
        $car->editReview($review_id, $form->vote, $form->text);
        $this->cars->save($car);
    }

    public function setParams($id, CarParamsForm $form): void
    {
        $car = $this->cars->get($id);
        $car->setParams(
            new CarParams(
                new AgeLimit(
                    $form->ageLimit->on,
                    $form->ageLimit->ageMin,
                    $form->ageLimit->ageMax),
                $form->min_rent,
                $form->delivery,
                $form->license,
                $form->experience
            )
        );
        foreach ($form->values as $value) {
            $car->setValue($value->id, $value->value);
        }

        $addresses = [];
        foreach ($form->address as $address_form) {
            if (!empty($address_form->address))
                $addresses[] = new BookingAddress($address_form->address, $address_form->latitude, $address_form->longitude);
        }
        $car->address = $addresses;

        $this->cars->save($car);
    }

    public function setExtra($id, $extra_id, $set): void
    {
        $car = $this->cars->get($id);
        echo $id . $extra_id . $set;
        if ($set) {
            $car->assignExtra($extra_id);
        } else {
            $car->revokeExtra($extra_id);
        }
        $this->cars->save($car);
    }

    public function setFinance($id, CarFinanceForm $form): void
    {
        $car = $this->cars->get($id);
        $car->setLegal($form->legal_id);
        $car->setCost($form->cost);
        $car->setDeposit($form->deposit);
        $car->setQuantity($form->quantity);
        $car->setDiscountOfDays($form->discount_of_days);
        //По умолчанию ч/з подтверждение
        $car->setCheckBooking(!empty($form->check_booking) ? $form->check_booking : BookingHelper::BOOKING_CONFIRMATION);
        //По умолчанию комиссия на Провайдере
        $car->setPayBank($form->pay_bank ?? true);
        $car->setCancellation(($form->cancellation == '') ? null : $form->cancellation);
        $this->cars->save($car);
    }

    public function verify($id)
    {
        $car = $this->cars->get($id);
        if (!$car->isInactive())
            throw new \DomainException('Нельзя отправить на модерацию');
        $car->setStatus(StatusHelper::STATUS_VERIFY);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            \Yii::$app->user->id,
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation(Car::class . ' ID=' . $car->id . '&'. 'STATUS=' . StatusHelper::STATUS_VERIFY);
        $this->dialogs->save($dialog);
        $this->contactService->sendActivate($car->name, $car->user->username);
        $this->cars->save($car);
    }

    public function cancel(int $id)
    {
        $car = $this->cars->get($id);
        if (!$car->isVerify())
            throw new \DomainException('Нельзя отменить');
        $car->setStatus(StatusHelper::STATUS_INACTIVE);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            \Yii::$app->user->id,
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation('ID=' . $car->id . '&'. 'STATUS=' . StatusHelper::STATUS_INACTIVE);
        $this->dialogs->save($dialog);
        $this->contactService->sendNoticeMessage($dialog);
        $this->cars->save($car);
    }

    public function draft(int $id)
    {
        $car = $this->cars->get($id);
        if (!$car->isActive())
            throw new \DomainException('Нельзя отправить в черновики');
        $car->setStatus(StatusHelper::STATUS_DRAFT);
        $this->cars->save($car);
    }

    public function activate(int $id)
    {
        $car = $this->cars->get($id);
        //Активировать можно только из Черновика, или с Модерации
        if ($car->isDraft() || $car->isVerify()) {
            if ($car->isVerify()) $car->public_at = time(); //Фиксируем дату публикации
            $car->setStatus(StatusHelper::STATUS_ACTIVE);
            $this->cars->save($car);
        } else {
            throw new \DomainException('Нельзя активировать');
        }
    }

    public function lock(int $id)
    {
        $car = $this->cars->get($id);
        $car->setStatus(StatusHelper::STATUS_LOCK);
        $this->cars->save($car);
        $this->contactService->sendLockCar($car);
    }

    public function unlock(int $id)
    {
        $car = $this->cars->get($id);
        if (!$car->isLock())
            throw new \DomainException('Нельзя разблокировать');
        $car->setStatus(StatusHelper::STATUS_INACTIVE);
        $this->cars->save($car);
    }

    public function support(int $id, $type)
    {
        //TODO !!!!! отправка жалобы на заблокированный объект
    }

    public function addCostCalendar(int $id, int $car_at, $count, $cost)
    {
        /** @var Car $car */
        $car = $this->cars->get($id);

        if ($this->calendars->isset($car->id, $car_at))
        {
            return 'Данное время (' . $car_at . ') уже занято';
        }
        $car->addCostCalendar(
            $car_at,
            $count,
            $cost
        );
        $this->cars->save($car);
    }

    public function clearCostCalendar(int $id, int $car_at)
    {
        $car = $this->cars->get($id);
        $calendars = $car->actualCalendar;
        foreach ($calendars as $i => $calendar) {
            if ($calendar->car_at == $car_at) {
                if ($calendar->isBooking()) throw new \DomainException('Нельзя изменить/удалить с бронированием');
                unset($calendars[$i]);
            }
        }
        $car->actualCalendar = $calendars;
        $this->cars->save($car);
    }

    public function upViews(Car $car)
    {
        $car->upViews();
        $this->cars->save($car);
    }

}