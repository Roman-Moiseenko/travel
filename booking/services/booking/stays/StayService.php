<?php

namespace booking\services\booking\stays;

use booking\entities\booking\BookingAddress;
use booking\entities\booking\AgeLimit;

use booking\entities\booking\stays\bedroom\AssignBed;
use booking\entities\booking\stays\bedroom\AssignRoom;
use booking\entities\booking\stays\CostCalendar;
use booking\entities\booking\stays\Photo;
use booking\entities\booking\stays\ReviewStay;
use booking\entities\booking\stays\rules\Beds;
use booking\entities\booking\stays\rules\CheckIn;
use booking\entities\booking\stays\rules\Limit;
use booking\entities\booking\stays\rules\Parking;
use booking\entities\booking\stays\rules\WiFi;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\stays\StayParams;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\entities\Meta;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\ReviewForm;

use booking\forms\booking\stays\StayBedroomsForm;
use booking\forms\booking\stays\StayComfortForm;
use booking\forms\booking\stays\StayComfortRoomForm;
use booking\forms\booking\stays\StayCommonForm;
use booking\forms\booking\stays\StayDutyForm;
use booking\forms\booking\stays\StayFinanceForm;
use booking\forms\booking\stays\StayNearbyForm;
use booking\forms\booking\stays\StayParamsForm;
use booking\forms\booking\stays\StayRulesForm;
use booking\forms\booking\stays\StayServicesForm;
use booking\forms\MetaForm;
use booking\helpers\BookingHelper;
use booking\helpers\Filling;
use booking\helpers\scr;
use booking\helpers\StatusHelper;

use booking\repositories\booking\ReviewRepository;
use booking\repositories\booking\stays\ReviewStayRepository;
use booking\repositories\booking\stays\StayRepository;
use booking\repositories\booking\stays\TypeRepository;
use booking\repositories\message\DialogRepository;
use booking\services\ContactService;
use booking\services\DialogService;
use booking\services\ImageService;
use booking\services\system\LoginService;
use booking\services\TransactionManager;

class StayService
{

    /**
     * @var StayRepository
     */
    private $stays;
    /**
     * @var TransactionManager
     */
    private $transaction;
    /**
     * @var TypeRepository
     */
    private $types;
    /**
     * @var ContactService
     */
    private $contactService;
    /**
     * @var ReviewStayRepository
     */
    private $reviews;
    /**
     * @var DialogRepository
     */
    private $dialogs;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        StayRepository $stays,
        TransactionManager $transaction,
        TypeRepository $types,
        ContactService $contactService,
        ReviewStayRepository $reviews,
        DialogRepository $dialogs,
        LoginService $loginService
    )
    {

        $this->stays = $stays;
        $this->transaction = $transaction;
        $this->types = $types;
        $this->contactService = $contactService;
        $this->reviews = $reviews;
        $this->dialogs = $dialogs;
        $this->loginService = $loginService;
    }

    public function create(StayCommonForm $form): Stay
    {
        $stay = Stay::create(
            $form->name,
            $form->type_id,
            $form->description,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            ),
            $form->name_en,
            $form->description_en,
            $form->city,
            $form->to_center
        );
        $stay->filling = Filling::COMMON;
        $this->stays->save($stay);
        return $stay;
    }

    public function edit($id, StayCommonForm $form): void
    {
        $stay = $this->stays->get($id);
        $stay->edit(
            $form->name,
            $form->type_id,
            $form->description,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            ),
            $form->name_en,
            $form->description_en,
            $form->city,
            $form->to_center
        );
        $this->stays->save($stay);
    }

    public function addPhotos($id, PhotosForm $form)
    {
        $stay = $this->stays->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $stay->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
        ini_set('max_execution_time', 180);
        $this->stays->save($stay);
        ini_set('max_execution_time', 30);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $stay = $this->stays->get($id);
        $stay->movePhotoUp($photoId);
        $this->stays->save($stay);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $stay = $this->stays->get($id);
        $stay->movePhotoDown($photoId);
        $this->stays->save($stay);
    }

    public function removePhoto($id, $photoId): void
    {
        $stay = $this->stays->get($id);
        $stay->removePhoto($photoId);
        $this->stays->save($stay);
    }

    public function addReview($tour_id, $user_id, ReviewForm $form)
    {
        $stay = $this->stays->get($tour_id);
        $review = $stay->addReview(ReviewStay::create($user_id, $form->vote, $form->text));
        $this->stays->save($stay);
        $this->contactService->sendNoticeReview($review);
    }

    public function removeReview($review_id)
    {
        $review = $this->reviews->get($review_id);
        $stay = $this->stays->get($review->stay_id);
        $stay->removeReview($review_id);
        $this->stays->save($stay);
    }

    public function editReview($review_id, ReviewForm $form)
    {
        $review = $this->reviews->get($review_id);
        $stay = $this->stays->get($review->stay_id);
        $stay->editReview($review_id, $form->vote, $form->text);
        $this->stays->save($stay);
    }

    public function setComfort($id, StayComfortForm $form)
    {
        $stay = $this->stays->get($id);
        foreach ($form->assignComforts as $item) {
            if ($item->checked) {
                $stay->setComfort($item->comfort_id, $item->pay, $item->file);
            } else {
                $stay->revokeComfort($item->comfort_id);
            }
        }
        $this->stays->save($stay);
    }

    public function setComfortRoom(int $id, StayComfortRoomForm $form)
    {
        $stay = $this->stays->get($id);
        foreach ($form->assignComfortsRoom as $item) {
            if ($item->checked) {
                $stay->setComfortRoom($item->comfort_id, $item->file);
            } else {
                $stay->revokeComfortRoom($item->comfort_id);
            }
        }
        $this->stays->save($stay);
    }

    public function setRules($id, StayRulesForm $form)
    {
        $stay = $this->stays->get($id);
        $rules = $stay->rules;
        $rules->setBeds(new Beds(
            $form->beds->child_on,
            $form->beds->child_agelimit,
            $form->beds->child_cost,
            $form->beds->child_by_adult,
            $form->beds->child_count,
            $form->beds->adult_on,
            $form->beds->adult_cost,
            $form->beds->adult_count
        ));
        $rules->setParking(new Parking(
            $form->parking->status,
            $form->parking->private,
            $form->parking->inside,
            $form->parking->reserve,
            $form->parking->cost,
            $form->parking->cost_type,
            $form->parking->security,
            $form->parking->covered,
            $form->parking->street,
            $form->parking->invalid
        ));
        $rules->setCheckin(new CheckIn(
            $form->checkin->checkin_from,
            $form->checkin->checkin_to,
            $form->checkin->checkout_from,
            $form->checkin->checkout_to,
            $form->checkin->message
        ));
        $rules->setLimit(new Limit(
            $form->limit->smoking,
            $form->limit->animals,
            $form->limit->children,
            $form->limit->children_allow
        ));
        $rules->setWifi(new WiFi(
            $form->wifi->status,
            $form->wifi->area,
            $form->wifi->cost,
            $form->wifi->cost_type
        ));
        $stay->updateRules($rules);
        $this->stays->save($stay);
    }

    public function setBedrooms($id, StayBedroomsForm $form)
    {
        $stay = $this->stays->get($id);
        $bedrooms = $stay->bedrooms;
        foreach ($bedrooms as $bedroom) {
            $bedroom->delete();
        }
        $i = 0;
        foreach ($form->bedrooms as $bedroomsForm) {
            $bedroom = AssignRoom::create($stay->id, $i++, $bedroomsForm->square);
            foreach ($bedroomsForm->bed_type as $j => $bed_id) {
                if ((int)$bedroomsForm->bed_count[$j] > 0)
                    $bedroom->addBed(AssignBed::create($bed_id, $bedroomsForm->bed_count[$j]));
            }
            $bedroom->save();
        }
        $this->stays->save($stay); //Не обязательно
    }

    public function setParams($id, StayParamsForm $form)
    {
        $stay = $this->stays->get($id);
        $stay->setParams(new StayParams(
            $form->square,
            $form->count_bath,
            $form->count_kitchen,
            $form->count_floor,
            $form->guest,
            $form->deposit,
            $form->access
        ));
        $this->stays->save($stay);
    }

    public function setNearby($id, StayNearbyForm $form)
    {
        $stay = $this->stays->get($id);
        $stay->clearNearby();
        $this->stays->save($stay);
        foreach ($form->nearby as $nearby) {
            $stay->addNearby(
                $nearby->name,
                $nearby->distance,
                $nearby->category_id,
                $nearby->unit
            );
        }
        $this->stays->save($stay);
    }

    public function setDuty(int $id, StayDutyForm $form)
    {
        $stay = $this->stays->get($id);
        $stay->clearDuty();
        $this->stays->save($stay);
       // scr::p($form->assignDuty);
        foreach ($form->assignDuty as $assignDutyForm) {
            if ($assignDutyForm->duty_id != 0) {
                $stay->addDuty(
                    $assignDutyForm->duty_id,
                    $assignDutyForm->value,
                    $assignDutyForm->payment,
                    $assignDutyForm->include
                );
            }
        }
        $this->stays->save($stay);
    }

    public function setServices(int $id, StayServicesForm $form)
    {
        $stay = $this->stays->get($id);
        $stay->clearServices();
        $this->stays->save($stay);
        foreach ($form->services as $customServicesForm) {
            $stay->addServices(
                $customServicesForm->name,
                $customServicesForm->value,
                $customServicesForm->payment
            );
        }
        $this->stays->save($stay);
    }

    public function setFinance($id, StayFinanceForm $form): void
    {
        $stay = $this->stays->get($id);
        $stay->setLegal($form->legal_id);
        $stay->cost_base = $form->cost_base;
        $stay->guest_base = $form->guest_base;
        $stay->cost_add = $form->cost_add;
        $stay->min_rent = $form->min_rent;
        //По умолчанию ч/з подтверждение
        $stay->setPrepay($form->prepay);
        $stay->setCancellation(($form->cancellation == '') ? null : $form->cancellation);
        $this->stays->save($stay);
    }

    public function verify($id)
    {
        $stay = $this->stays->get($id);
        if (!$stay->isInactive())
            throw new \DomainException('Нельзя отправить на модерацию');

        if ($stay->mainPhoto == null) {
            throw new \DomainException('Вы не добавили ни одной фотографии!');
        }

        $stay->setStatus(StatusHelper::STATUS_VERIFY);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            $this->loginService->admin()->getId(),
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation(Stay::class . ' ID=' . $stay->id . '&' . 'STATUS=' . StatusHelper::STATUS_VERIFY);
        $this->dialogs->save($dialog);
        $this->contactService->sendActivate($stay->name, $stay->user->username);
        $this->stays->save($stay);
    }

    public function cancel(int $id)
    {
        $stay = $this->stays->get($id);
        if (!$stay->isVerify())
            throw new \DomainException('Нельзя отменить');
        $stay->setStatus(StatusHelper::STATUS_INACTIVE);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            $this->loginService->admin()->getId(),
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation('ID=' . $stay->id . '&' . 'STATUS=' . StatusHelper::STATUS_INACTIVE);
        $this->dialogs->save($dialog);
        $this->contactService->sendNoticeMessage($dialog);
        $this->stays->save($stay);
    }

    public function draft(int $id)
    {
        $stay = $this->stays->get($id);
        if (!$stay->isActive())
            throw new \DomainException('Нельзя отправить в черновики');
        $stay->setStatus(StatusHelper::STATUS_DRAFT);
        $this->stays->save($stay);
    }

    public function activate(int $id)
    {
        $stay = $this->stays->get($id);
        //Активировать можно только из Черновика, или с Модерации
        if ($stay->isDraft() || $stay->isVerify()) {
            if ($stay->isVerify()) $stay->public_at = time(); //Фиксируем дату публикации
            $stay->setStatus(StatusHelper::STATUS_ACTIVE);
            $this->stays->save($stay);
        } else {
            throw new \DomainException('Нельзя активировать');
        }
    }

    public function lock(int $id)
    {
        $stay = $this->stays->get($id);
        $stay->setStatus(StatusHelper::STATUS_LOCK);
        $this->stays->save($stay);
        $this->contactService->sendLock($stay);
    }

    public function unlock(int $id)
    {
        $stay = $this->stays->get($id);
        if (!$stay->isLock())
            throw new \DomainException('Нельзя разблокировать');
        $stay->setStatus(StatusHelper::STATUS_INACTIVE);
        $this->stays->save($stay);
    }

    public function support(int $id, $type)
    {
        //TODO !!!!! отправка жалобы на заблокированный объект
    }

    public function clearCostCalendar(int $id, int $stay_at)
    {
        $stay = $this->stays->get($id);
        $calendars = $stay->actualCalendar;
        foreach ($calendars as $i => $calendar) {
            if ($calendar->stay_at == $stay_at) {
                if ($calendar->isBooking()) throw new \DomainException('Нельзя изменить/удалить с бронированием');
                unset($calendars[$i]);
            }
        }
        $stay->actualCalendar = $calendars;
        $this->stays->save($stay);
    }

    public function addCostCalendar($stay_id, $stay_at, $cost_base, $guest_base, $cost_add)
    {
        $stay = $this->stays->get($stay_id);
        $stay->addCostCalendar(CostCalendar::create($stay_at, $cost_base, $guest_base, $cost_add));
        $this->stays->save($stay);
    }


    public function copyCostCalendar(int $id, $new_day, $copy_day)
    {
        $stay = $this->stays->get($id);
        $calendars = $stay->actualCalendar;
        foreach ($calendars as $calendar) {
            if ($calendar->stay_at === $copy_day) {
                $calendars[] = CostCalendar::create(
                    $new_day,
                    $calendar->cost_base,
                    $calendar->guest_base,
                    $calendar->cost_add
                );
            }
        }
        $stay->actualCalendar = $calendars;
        $this->stays->save($stay);
    }

    public function setMeta($id, MetaForm $form)
    {
        $stay = $this->stays->get($id);
        $stay->setMeta(new Meta($form->title, $form->description, $form->keywords));
        $this->stays->save($stay);
    }

    public function upViews(Stay $stay)
    {
        $stay->upViews();
        $this->stays->save($stay);
    }

    /** FILLING */

    public function next_filling(Stay $stay)
    {
        if ($stay->filling == null) return null;
        $next = [
            Filling::COMMON => Filling::COMFORT,
            Filling::COMFORT => Filling::COMFORT_ROOM,
            Filling::COMFORT_ROOM => Filling::RULES,
            Filling::RULES => Filling::BEDROOMS,
            Filling::BEDROOMS => Filling::PARAMS,
            Filling::PARAMS => Filling::NEARBY,
            Filling::NEARBY => Filling::DUTY,
            Filling::DUTY => Filling::SERVICES,
            Filling::SERVICES => Filling::PHOTOS,
            Filling::PHOTOS => Filling::FINANCE,
            Filling::FINANCE => Filling::CALENDAR,
            Filling::CALENDAR => null,
        ];
        $stay->filling = $next[$stay->filling];
        $this->stays->save($stay);
        return $this->redirect_filling($stay);
    }

    public function redirect_filling(Stay $stay)
    {
        if ($stay->filling == null) return null;
        $redirect = [
            Filling::COMMON => ['/stay/common/create', 'id' => $stay->id],
            Filling::COMFORT => ['/stay/comfort/update', 'id' => $stay->id],
            Filling::COMFORT_ROOM => ['/stay/comfort-room/update', 'id' => $stay->id],
            Filling::RULES => ['/stay/rules/update', 'id' => $stay->id],
            Filling::BEDROOMS => ['/stay/bedrooms/update', 'id' => $stay->id],
            Filling::PARAMS => ['/stay/params/update', 'id' => $stay->id],
            Filling::NEARBY => ['/stay/nearby/update', 'id' => $stay->id],
            Filling::DUTY => ['/stay/duty/update', 'id' => $stay->id],
            Filling::SERVICES => ['/stay/services/update', 'id' => $stay->id],
            Filling::PHOTOS => ['/stay/photos/index', 'id' => $stay->id],
            Filling::FINANCE => ['/stay/finance/update', 'id' => $stay->id],
            Filling::CALENDAR => ['/stay/calendar/index', 'id' => $stay->id],
        ];
        return $redirect[$stay->filling];
    }




}