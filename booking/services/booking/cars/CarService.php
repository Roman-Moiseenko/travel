<?php

namespace booking\services\booking\cars;

use booking\entities\booking\AgeLimit;
use booking\entities\booking\BookingAddress;
use booking\entities\booking\cars\Car;
use booking\entities\booking\cars\CarParams;
use booking\entities\booking\cars\CostCalendar;
use booking\entities\booking\cars\Photo;
use booking\entities\booking\cars\ReviewCar;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\entities\Meta;
use booking\forms\booking\cars\CarCommonForm;
use booking\forms\booking\cars\CarFinanceForm;
use booking\forms\booking\cars\CarParamsForm;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\ReviewForm;
use booking\forms\MetaForm;
use booking\helpers\BookingHelper;
use booking\helpers\Filling;
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
use booking\services\system\LoginService;
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
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        CarRepository $cars,
        TransactionManager $transaction,
        TypeRepository $types,
        ExtraRepository $extra,
        ContactService $contactService,
        ReviewCarRepository $reviews,
        DialogRepository $dialogs,
        CostCalendarRepository $calendars,
        LoginService $loginService
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
        $this->loginService = $loginService;
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
        $car->filling = Filling::COMMON;
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
                $car->addPhoto(Photo::create($file));
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
        $review = $car->addReview(ReviewCar::create($user_id, $form->vote, $form->text));
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
        $car->setPrepay($form->prepay);
        $car->setCancellation(($form->cancellation == '') ? null : $form->cancellation);
        $this->cars->save($car);
    }

    public function verify($id)
    {
        $car = $this->cars->get($id);
        if (!$car->isInactive())
            throw new \DomainException('Нельзя отправить на модерацию');

        if ($car->mainPhoto == null) {
            throw new \DomainException('Вы не добавили ни одной фотографии!');
        }

        if ($car->params->min_rent == null) {
            throw new \DomainException('Необходимо заполнить параметры');
        }

        if ($car->cost == null) {
            throw new \DomainException('Не заполнен раздел Цена!');
        }

        $car->setStatus(StatusHelper::STATUS_VERIFY);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            $this->loginService->admin()->getId(),
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
            $this->loginService->admin()->getId(),
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
        $this->contactService->sendLock($car);
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
        $car->addCostCalendar(CostCalendar::create(
            $car_at,
            $cost,
            $count
        ));
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

    public function setMeta($id, MetaForm $form)
    {
        $car = $this->cars->get($id);
        $car->setMeta(new Meta($form->title, $form->description, $form->keywords));
        $this->cars->save($car);
    }

    public function upViews(Car $car)
    {
        $car->upViews();
        $this->cars->save($car);
    }

    /** FILLING */

    public function next_filling(Car $car)
    {
        if ($car->filling == null) return null;
        $next = [
            Filling::COMMON => Filling::PHOTOS,
            Filling::PHOTOS => Filling::PARAMS,
            Filling::PARAMS => Filling::EXTRA,
            Filling::EXTRA => Filling::FINANCE,
            Filling::FINANCE => Filling::CALENDAR,
            Filling::CALENDAR => null
        ];
        $car->filling = $next[$car->filling];
        $this->cars->save($car);
        return $this->redirect_filling($car);
    }

    public function redirect_filling(Car $car)
    {
        if ($car->filling == null) return null;
        $redirect = [
            Filling::COMMON => ['/car/common/create', 'id' => $car->id],
            Filling::PHOTOS => ['/car/photos/index', 'id' => $car->id],
            Filling::PARAMS => ['/car/params/update', 'id' => $car->id],
            Filling::EXTRA => ['/car/extra/index', 'id' => $car->id],
            Filling::FINANCE => ['/car/finance/update', 'id' => $car->id],
            Filling::CALENDAR => ['/car/calendar/index', 'id' => $car->id],
        ];
        return $redirect[$car->filling];
    }
}