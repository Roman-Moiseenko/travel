<?php

namespace booking\services\booking\funs;

use booking\entities\booking\BookingAddress;
use booking\entities\booking\AgeLimit;
use booking\entities\booking\funs\CostCalendar;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\FunParams;
use booking\entities\booking\funs\Photo;
use booking\entities\booking\funs\ReviewFun;
use booking\entities\booking\funs\Times;
use booking\entities\WorkMode;
use booking\entities\booking\tours\Cost;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\entities\Meta;
use booking\forms\booking\funs\FunCommonForm;
use booking\forms\booking\funs\FunFinanceForm;
use booking\forms\booking\funs\FunParamsForm;
use booking\forms\WorkModeForm;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\ReviewForm;
use booking\forms\MetaForm;
use booking\helpers\BookingHelper;
use booking\helpers\Filling;
use booking\helpers\StatusHelper;
use booking\repositories\booking\funs\CostCalendarRepository;
use booking\repositories\booking\funs\ExtraRepository;
use booking\repositories\booking\funs\FunRepository;
use booking\repositories\booking\funs\ReviewFunRepository;
use booking\repositories\booking\funs\TypeRepository;
use booking\repositories\message\DialogRepository;
use booking\services\ContactService;
use booking\services\ImageService;
use booking\services\system\LoginService;
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
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        FunRepository $funs,
        TransactionManager $transaction,
        TypeRepository $types,
        ExtraRepository $extra,
        ContactService $contactService,
        ReviewFunRepository $reviews,
        DialogRepository $dialogs,
        CostCalendarRepository $calendars,
        LoginService $loginService
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
        $this->loginService = $loginService;
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
        $fun->filling = Filling::COMMON;
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
                $fun->addPhoto(Photo::create($file));
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
        $review = $fun->addReview(ReviewFun::create($user_id, $form->vote, $form->text));
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
        $fun->setPrepay($form->prepay);
        //По умолчанию комиссия на Провайдере
        $fun->setCancellation(($form->cancellation == '') ? null : $form->cancellation);

        $this->funs->save($fun);
    }

    public function verify($id)
    {
        $fun = $this->funs->get($id);
        if (!$fun->isInactive())
            throw new \DomainException('Нельзя отправить на модерацию');
        if ($fun->mainPhoto == null) {
            throw new \DomainException('Вы не добавили ни одной фотографии!');
        }

        if ($fun->baseCost->adult == null) {
            throw new \DomainException('Не заполнен раздел Цена!');
        }
        $fun->setStatus(StatusHelper::STATUS_VERIFY);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            $this->loginService->admin()->getId(),
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
            $this->loginService->admin()->getId(),
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
        $fun->addCostCalendar(CostCalendar::create(
            $fun_at,
            $time_at,
            new Cost($cost_adult, $cost_child, $cost_preference),
            $tickets
        ));
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
            }
        }
        $fun->actualCalendar = $calendars;
        $this->funs->save($fun);
    }

    public function setMeta($id, MetaForm $form)
    {
        $fun = $this->funs->get($id);
        $fun->setMeta(new Meta($form->title, $form->description, $form->keywords));
        $this->funs->save($fun);
    }

    public function upViews(Fun $fun)
    {
        $fun->upViews();
        $this->funs->save($fun);
    }

    /** FILLING */

    public function next_filling(Fun $fun)
    {
        if ($fun->filling == null) return null;
        $next = [
            Filling::COMMON => Filling::PHOTOS,
            Filling::PHOTOS => Filling::PARAMS,
            Filling::PARAMS => Filling::EXTRA,
            Filling::EXTRA => Filling::FINANCE,
            Filling::FINANCE => Filling::CALENDAR,
            Filling::CALENDAR => null
        ];
        $fun->filling = $next[$fun->filling];
        $this->funs->save($fun);
        return $this->redirect_filling($fun);
    }

    public function redirect_filling(Fun $fun)
    {
        if ($fun->filling == null) return null;
        $redirect = [
            Filling::COMMON => ['/fun/common/create', 'id' => $fun->id],
            Filling::PHOTOS => ['/fun/photos/index', 'id' => $fun->id],
            Filling::PARAMS => ['/fun/params/update', 'id' => $fun->id],
            Filling::EXTRA => ['/fun/extra/index', 'id' => $fun->id],
            Filling::FINANCE => ['/fun/finance/update', 'id' => $fun->id],
            Filling::CALENDAR => ['/fun/calendar/index', 'id' => $fun->id],
        ];
        return $redirect[$fun->filling];
    }
}