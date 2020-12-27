<?php

namespace booking\services\booking\funs;

use booking\entities\booking\BookingAddress;
use booking\entities\booking\AgeLimit;
use booking\entities\booking\funs\CostCalendar;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\FunParams;
use booking\entities\booking\funs\Times;
use booking\entities\booking\funs\WorkMode;
use booking\entities\booking\tours\Cost;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\forms\booking\funs\FunCommonForm;
use booking\forms\booking\funs\FunFinanceForm;
use booking\forms\booking\funs\FunParamsForm;
use booking\forms\booking\funs\WorkModeForm;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\helpers\StatusHelper;
use booking\repositories\booking\funs\CostCalendarRepository;
use booking\repositories\booking\funs\ExtraRepository;
use booking\repositories\booking\funs\FunRepository;
use booking\repositories\booking\funs\ReviewFunRepository;
use booking\repositories\booking\funs\TypeRepository;
use booking\repositories\message\DialogRepository;
use booking\services\ContactService;
use booking\services\ImageService;
use booking\services\TransactionManager;

class FunService
{
    /**
     * @var FunRepository
     */
    private $funs;
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
     * @var ReviewFunRepository
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
        FunRepository $funs,
        TransactionManager $transaction,
        TypeRepository $types,
        ExtraRepository $extra,
        ContactService $contactService,
        ReviewFunRepository $reviews,
        DialogRepository $dialogs,
        CostCalendarRepository $calendars
    )
    {
        $this->funs = $funs;
        $this->transaction = $transaction;
        $this->types = $types;
        $this->extra = $extra;
        $this->contactService = $contactService;
        $this->reviews = $reviews;
        $this->dialogs = $dialogs;
        $this->calendars = $calendars;
    }

    public function create(FunCommonForm $form): Fun
    {
        $fun = Fun::create(
            $form->name,
            $form->description,
            $form->type_id,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            ),
            $form->name_en,
            $form->description_en
        );

        $this->funs->save($fun);
        return $fun;
    }

    public function edit($id, FunCommonForm $form): void
    {
        $fun = $this->funs->get($id);
        $fun->edit(
            $form->name,
            $form->description,
            $form->type_id,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            ),
            $form->name_en,
            $form->description_en
        );
        $this->funs->save($fun);
    }

    public function addPhotos($id, PhotosForm $form)
    {
        $fun = $this->funs->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $fun->addPhoto($file);
                ImageService::rotate($file->tempName);
            }
        ini_set('max_execution_time', 180);
        $this->funs->save($fun);
        ini_set('max_execution_time', 30);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $fun = $this->funs->get($id);
        $fun->movePhotoUp($photoId);
        $this->funs->save($fun);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $fun = $this->funs->get($id);
        $fun->movePhotoDown($photoId);
        $this->funs->save($fun);
    }

    public function removePhoto($id, $photoId): void
    {
        $fun = $this->funs->get($id);
        $fun->removePhoto($photoId);
        $this->funs->save($fun);
    }

    public function addReview($fun_id, $user_id, ReviewForm $form)
    {
        $fun = $this->funs->get($fun_id);
        $review = $fun->addReview($user_id, $form->vote, $form->text);
        $this->funs->save($fun);
        $this->contactService->sendNoticeReview($review);
    }

    public function removeReview($review_id)
    {
        $review = $this->reviews->get($review_id);
        $fun = $this->funs->get($review->fun_id);
        $fun->removeReview($review_id);
        $this->funs->save($fun);
    }

    public function editReview($review_id, ReviewForm $form)
    {
        $review = $this->reviews->get($review_id);
        $fun = $this->funs->get($review->fun_id);
        $fun->editReview($review_id, $form->vote, $form->text);
        $this->funs->save($fun);
    }

    public function setParams($id, FunParamsForm $form): void
    {
        $fun = $this->funs->get($id);
        $fun->setParams(
            new FunParams(
                new AgeLimit(
                    $form->ageLimit->on,
                    $form->ageLimit->ageMin,
                    $form->ageLimit->ageMax
                ),
                $form->annotation,
                array_map(function (WorkModeForm $modeForm) {
                    return new WorkMode(
                        $modeForm->day_begin,
                        $modeForm->day_end,
                        $modeForm->break_begin,
                        $modeForm->break_end
                    );
                }, $form->workModes)
            )
        );
        foreach ($form->values as $value) {
            $fun->setValue($value->id, $value->value);
        }
        $this->funs->save($fun);
    }

    public function setExtra($id, $extra_id, $set): void
    {

        $fun = $this->funs->get($id);
        echo $id . $extra_id . $set;
        if ($set) {
            $fun->assignExtra($extra_id);
        } else {
            $fun->revokeExtra($extra_id);
        }
        $this->funs->save($fun);
    }

    public function setFinance($id, FunFinanceForm $form): void
    {
        $fun = $this->funs->get($id);
        $fun->setLegal($form->legal_id);
        $fun->setQuantity($form->quantity);

        $fun->times = [];
        foreach ($form->times as $timesForm) {
            if (!empty($timesForm->begin))
                $fun->times[] = new Times($timesForm->begin, $timesForm->end);
        }

        $fun->type_time = $form->type_time;
        if ($form->type_time != Fun::TYPE_TIME_INTERVAL) {
            $fun->multi = false;
        } else {
            $fun->multi = $form->multi;
        }
        //$fun->times = $form->times
        $fun->setCost(
            new Cost(
                $form->baseCost->adult,
                $form->baseCost->child,
                $form->baseCost->preference
            )
        );
        //По умолчанию ч/з подтверждение
        $fun->setCheckBooking(!empty($form->check_booking) ? $form->check_booking : BookingHelper::BOOKING_CONFIRMATION);
        //По умолчанию комиссия на Провайдере
        $fun->setPayBank($form->pay_bank ?? true);
        $fun->setCancellation(($form->cancellation == '') ? null : $form->cancellation);

        $this->funs->save($fun);
    }

    public function verify($id)
    {
        $fun = $this->funs->get($id);
        if (!$fun->isInactive())
            throw new \DomainException('Нельзя отправить на модерацию');
        $fun->setStatus(StatusHelper::STATUS_VERIFY);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            \Yii::$app->user->id,
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation(Fun::class . ' ID=' . $fun->id . '&' . 'STATUS=' . StatusHelper::STATUS_VERIFY);
        $this->dialogs->save($dialog);
        $this->contactService->sendActivate($fun->name, $fun->user->username);
        $this->funs->save($fun);
    }

    public function cancel(int $id)
    {
        $fun = $this->funs->get($id);
        if (!$fun->isVerify())
            throw new \DomainException('Нельзя отменить');
        $fun->setStatus(StatusHelper::STATUS_INACTIVE);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            \Yii::$app->user->id,
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation('ID=' . $fun->id . '&' . 'STATUS=' . StatusHelper::STATUS_INACTIVE);
        $this->dialogs->save($dialog);
        $this->contactService->sendNoticeMessage($dialog);
        $this->funs->save($fun);
    }

    public function draft(int $id)
    {
        $fun = $this->funs->get($id);
        if (!$fun->isActive())
            throw new \DomainException('Нельзя отправить в черновики');
        $fun->setStatus(StatusHelper::STATUS_DRAFT);
        $this->funs->save($fun);
    }

    public function activate(int $id)
    {
        $fun = $this->funs->get($id);
        //Активировать можно только из Черновика, или с Модерации
        if ($fun->isDraft() || $fun->isVerify()) {
            if ($fun->isVerify()) $fun->public_at = time(); //Фиксируем дату публикации
            $fun->setStatus(StatusHelper::STATUS_ACTIVE);
            $this->funs->save($fun);
        } else {
            throw new \DomainException('Нельзя активировать');
        }
    }

    public function lock(int $id)
    {
        $fun = $this->funs->get($id);
        $fun->setStatus(StatusHelper::STATUS_LOCK);
        $this->funs->save($fun);
        $this->contactService->sendLockFun($fun);
    }

    public function unlock(int $id)
    {
        $fun = $this->funs->get($id);
        if (!$fun->isLock())
            throw new \DomainException('Нельзя разблокировать');
        $fun->setStatus(StatusHelper::STATUS_INACTIVE);
        $this->funs->save($fun);
    }

    public function support(int $id, $type)
    {
        //TODO !!!!! отправка жалобы на заблокированный объект
    }

    /*********************** **/
    public function addCostCalendar(int $id, int $fun_at, $time_at, $tickets, $cost_adult, $cost_child, $cost_preference)
    {
        /** @var Fun $fun */
        $fun = $this->funs->get($id);
        $fun->addCostCalendar(
            $fun_at,
            $time_at,
            $tickets,
            $cost_adult,
            $cost_child,
            $cost_preference
        );
        $this->funs->save($fun);
    }

    public function clearCostCalendar(int $id, int $fun_at)
    {
        $fun = $this->funs->get($id);
        $calendars = $fun->actualCalendar;
        foreach ($calendars as $i => $calendar) {
            if ($calendar->fun_at == $fun_at) {
                if ($calendar->isBooking()) throw new \DomainException('Нельзя изменить/удалить с бронированием');
                unset($calendars[$i]);
            }
        }
        $fun->actualCalendar = $calendars;
        $this->funs->save($fun);
    }

    public function copyCostCalendar($id, $new_day, $copy_day)
    {
        $fun = $this->funs->get($id);
        $calendars = $fun->actualCalendar;
        //$temp_array = [];
        foreach ($calendars as $calendar) {
            if ($calendar->fun_at === $copy_day) {
                $calendars[] = CostCalendar::create(
                    $new_day,
                    $calendar->time_at,
                    new Cost(
                        $calendar->cost->adult,
                        $calendar->cost->child,
                        $calendar->cost->preference
                    ),
                    $calendar->tickets
                );
                //$calendar_copy->fun_at = $new_day;
                //$temp_array[] = $calendar_copy;
            }
        }
        $fun->actualCalendar = $calendars;
        $this->funs->save($fun);
    }
}