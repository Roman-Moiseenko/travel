<?php

namespace booking\services\booking\stays;

use booking\entities\booking\BookingAddress;
use booking\entities\booking\AgeLimit;

use booking\entities\booking\stays\bedroom\AssignBed;
use booking\entities\booking\stays\bedroom\AssignRoom;
use booking\entities\booking\stays\rules\Beds;
use booking\entities\booking\stays\rules\CheckIn;
use booking\entities\booking\stays\rules\Limit;
use booking\entities\booking\stays\rules\Parking;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\stays\StayParams;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\ReviewForm;

use booking\forms\booking\stays\StayBedroomsForm;
use booking\forms\booking\stays\StayComfortForm;
use booking\forms\booking\stays\StayCommonForm;
use booking\forms\booking\stays\StayDutyForm;
use booking\forms\booking\stays\StayNearbyForm;
use booking\forms\booking\stays\StayParamsForm;
use booking\forms\booking\stays\StayRulesForm;
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

    public function __construct(
        StayRepository $stays,
        TransactionManager $transaction,
        TypeRepository $types,
        //ExtraRepository $extra,
        ContactService $contactService,
        ReviewStayRepository $reviews,
        DialogRepository $dialogs
       // CostCalendarRepository $calendars
    )
    {

        $this->stays = $stays;
        $this->transaction = $transaction;
        $this->types = $types;
        $this->contactService = $contactService;
        $this->reviews = $reviews;
        $this->dialogs = $dialogs;
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
            $form->description_en
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
            $form->description_en
        );
        $this->stays->save($stay);
    }

    public function addPhotos($id, PhotosForm $form)
    {
        $stay = $this->stays->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $stay->addPhoto($file);
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
        $review = $stay->addReview($user_id, $form->vote, $form->text);
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
        $stay->revokeComforts();
        $this->stays->save($stay);

        foreach ($form->assignComforts as $item) {
            if ($item->comfort_id != 0) {
                //scr::_p($item->comfort_id);
                $stay->addComfort($item->comfort_id, $item->pay, $item->photo_id);
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
            $bedroom = AssignRoom::create($stay->id, $i++);
            foreach ($bedroomsForm->bed_type as $j => $bed_id) {
                if ((int)$bedroomsForm->bed_count[$j] > 0)
                    $bedroom->addBed(AssignBed::create($bed_id, $bedroomsForm->bed_count[$j]));
            }
            $bedroom->save();
        }
        $this->stays->save($stay);
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
/*


    public function setFinance($id, TourFinanceForm $form): void
    {
        $stay = $this->stays->get($id);
        $stay->setLegal($form->legal_id);
        $stay->setCost(
            new Cost(
                $form->baseCost->adult,
                $form->baseCost->child,
                $form->baseCost->preference
            )
        );
        //По умолчанию ч/з подтверждение
        $stay->setCheckBooking(!empty($form->check_booking) ? $form->check_booking : BookingHelper::BOOKING_CONFIRMATION);
        $stay->setCancellation(($form->cancellation == '') ? null : $form->cancellation);
        $this->stays->save($stay);
    }
*/
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
            \Yii::$app->user->id,
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
            \Yii::$app->user->id,
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
        $this->contactService->sendLockStay($stay);
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

    public function addCostCalendar(int $id, int $stay_at)
    {

        //TODO  addCostCalendar
        $stay = $this->stays->get($id);
/*
        $stay->addCostCalendar(
            $tour_at,
            $time_at,
            $tickets,
            $cost_adult,
            $cost_child,
            $cost_preference
        );*/
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
            Filling::COMFORT => Filling::RULES,
            Filling::RULES => Filling::BEDROOMS,
            Filling::BEDROOMS => Filling::PARAMS,
            Filling::PARAMS => Filling::NEARBY,
            Filling::NEARBY => Filling::DUTY,
            Filling::DUTY => Filling::PHOTOS,
            Filling::PHOTOS => null,
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
            Filling::RULES => ['/stay/rules/update', 'id' => $stay->id],
            Filling::BEDROOMS => ['/stay/bedrooms/update', 'id' => $stay->id],
            Filling::PARAMS => ['/stay/params/update', 'id' => $stay->id],
            Filling::NEARBY => ['/stay/nearby/update', 'id' => $stay->id],
            Filling::DUTY => ['/stay/duty/update', 'id' => $stay->id],
            Filling::PHOTOS => ['/stay/photos/index', 'id' => $stay->id],
        ];
        return $redirect[$stay->filling];
    }
}