<?php

namespace booking\services\booking\tours;

use booking\entities\booking\BookingAddress;
use booking\entities\booking\AgeLimit;
use booking\entities\booking\tours\Cost;
use booking\entities\booking\tours\CostCalendar;
use booking\entities\booking\tours\Photo;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\TourParams;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\entities\Meta;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\ReviewForm;
use booking\forms\booking\tours\CostForm;
use booking\forms\booking\tours\TourCommonForm;
use booking\forms\booking\tours\TourExtraForm;
use booking\forms\booking\tours\TourFinanceForm;
use booking\forms\booking\tours\TourParamsForm;
use booking\forms\MetaForm;
use booking\helpers\BookingHelper;
use booking\helpers\Filling;
use booking\helpers\scr;
use booking\helpers\StatusHelper;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\booking\tours\ExtraRepository;
use booking\repositories\booking\tours\ReviewTourRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\repositories\booking\tours\TypeRepository;
use booking\repositories\booking\ReviewRepository;
use booking\repositories\message\DialogRepository;
use booking\services\ContactService;
use booking\services\DialogService;
use booking\services\ImageService;
use booking\services\system\LoginService;
use booking\services\TransactionManager;

class TourService
{
    private $tours;
    private $transaction;
    private $types;
    private $extra;
    private $contactService;
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
        TourRepository $tours,
        TransactionManager $transaction,
        TypeRepository $types,
        ExtraRepository $extra,
        ContactService $contactService,
        ReviewTourRepository $reviews,
        DialogRepository $dialogs,
        CostCalendarRepository $calendars,
        LoginService $loginService
    )
    {
        $this->tours = $tours;
        $this->transaction = $transaction;
        $this->types = $types;
        $this->extra = $extra;
        $this->contactService = $contactService;
        $this->reviews = $reviews;
        $this->dialogs = $dialogs;
        $this->calendars = $calendars;
        $this->loginService = $loginService;
    }

    public function create(TourCommonForm $form): Tour
    {
        $tour = Tour::create(
            $this->loginService->admin()->getId(),
            $form->name,
            $form->types->main,
            $form->description,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            ),
            $form->name_en,
            $form->description_en,
            $form->slug
        );
        foreach ($form->types->others as $otherId) {
            $type = $this->types->get($otherId);
            $tour->assignType($type->id);
        }
        $tour->filling = Filling::COMMON;
        $this->tours->save($tour);
        return $tour;
    }

    public function edit($id, TourCommonForm $form): void
    {
        $tour = $this->tours->get($id);
        $tour->edit(
            $form->name,
            $form->types->main,
            $form->description,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            ),
            $form->name_en,
            $form->description_en,
            $form->slug
        );
        $this->transaction->wrap(function () use ($form, $tour) {
            $tour->clearType();
            $this->tours->save($tour);
            foreach ($form->types->others as $otherId) {
                $type = $this->types->get($otherId);
                $tour->assignType($type->id);
            }
            $this->tours->save($tour);
        });
    }

    public function addPhotos($id, PhotosForm $form)
    {
        $tour = $this->tours->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $tour->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
        ini_set('max_execution_time', 180);
        $this->tours->save($tour);
        ini_set('max_execution_time', 30);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $tour = $this->tours->get($id);
        $tour->movePhotoUp($photoId);
        $this->tours->save($tour);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $tour = $this->tours->get($id);
        $tour->movePhotoDown($photoId);
        $this->tours->save($tour);
    }

    public function removePhoto($id, $photoId): void
    {
        $tour = $this->tours->get($id);
        $tour->removePhoto($photoId);
        $this->tours->save($tour);
    }

    public function addReview($tour_id, $user_id, ReviewForm $form)
    {
        $tour = $this->tours->get($tour_id);
        $review = $tour->addReview(ReviewTour::create($user_id, $form->vote, $form->text));
        $this->tours->save($tour);
        $this->contactService->sendNoticeReview($review);
    }

    public function removeReview($review_id)
    {
        $review = $this->reviews->get($review_id);
        $tour = $this->tours->get($review->tour_id);
        $tour->removeReview($review_id);
        $this->tours->save($tour);
    }

    public function editReview($review_id, ReviewForm $form)
    {
        $review = $this->reviews->get($review_id);
        $tour = $this->tours->get($review->tour_id);
        $tour->editReview($review_id, $form->vote, $form->text);
        $this->tours->save($tour);
    }

    public function setParams($id, TourParamsForm $form): void
    {
        $tour = $this->tours->get($id);
        $tour->setParams(
            new TourParams(
                $form->duration,
                new BookingAddress(
                    $form->beginAddress->address,
                    $form->beginAddress->latitude,
                    $form->beginAddress->longitude
                ),
                new BookingAddress(
                    $form->endAddress->address,
                    $form->endAddress->latitude,
                    $form->endAddress->longitude
                ),
                new AgeLimit(
                    $form->ageLimit->on,
                    $form->ageLimit->ageMin,
                    $form->ageLimit->ageMax
                ),
                $form->private,
                $form->groupMin,
                $form->groupMax
            )
        );
        if ($tour->isPrivate()) {
            $tour->setCost(
                new Cost(
                    $tour->baseCost->adult,
                    null,
                    null
                )
            );
        }
        $this->tours->save($tour);
    }

    public function setExtra($id, $extra_id, $set /*ToursExtraForm $form*/): void
    {

        $tour = $this->tours->get($id);
        //echo $id . $extra_id . $set;
        if ($set) {
            $tour->assignExtra($extra_id);
        } else {
            $tour->revokeExtra($extra_id);
        }
        $this->tours->save($tour);
        /*
        $this->transaction->wrap(function () use ($form, $tours) {
            $tours->clearExtra();
            $this->tours->save($tours);
            foreach ($form->assign as $extra_id) {
                $extra = $this->extra->get($extra_id);
                $tours->assignExtra($extra->id);
            }
            $this->tours->save($tours);
        });*/

    }

    public function setFinance($id, TourFinanceForm $form): void
    {
        $tour = $this->tours->get($id);
        $tour->setLegal($form->legal_id);
        $tour->setCost(
            new Cost(
                $form->baseCost->adult,
                $form->baseCost->child,
                $form->baseCost->preference
            )
        );
        $tour->setPrepay($form->prepay);
        $tour->setCancellation(($form->cancellation == '') ? null : $form->cancellation);
        $tour->setExtraTime($form->extra_time_cost, $form->extra_time_max);
        $tour->clearCapacity();
        $tour->clearTransfer();
        $this->tours->save($tour);
        foreach ($form->capacities as $capacity_id)
            $tour->assignCapacity($capacity_id);
        foreach ($form->transfers as $transfer_id)
            $tour->assignTransfer($transfer_id);
        $this->tours->save($tour);
    }

    public function verify($id)
    {
        $tour = $this->tours->get($id);
        if (!$tour->isInactive())
            throw new \DomainException('Нельзя отправить на модерацию');

        if ($tour->mainPhoto == null) {
            throw new \DomainException('Вы не добавили ни одной фотографии!');
        }
        //scr::p($tour->params->private);
        if ($tour->params->private === null) {
            throw new \DomainException('Необходимо заполнить параметры');
        }

        if ($tour->baseCost->adult == null) {
            throw new \DomainException('Не заполнен раздел Цена!');
        }

        $tour->setStatus(StatusHelper::STATUS_VERIFY);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            $this->loginService->admin()->getId(),
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation(Tour::class . ' ID=' . $tour->id . '&' . 'STATUS=' . StatusHelper::STATUS_VERIFY);
        $this->dialogs->save($dialog);
        $this->contactService->sendActivate($tour->name, $tour->user->username);
        $this->tours->save($tour);
    }

    public function cancel(int $id)
    {
        $tour = $this->tours->get($id);
        if (!$tour->isVerify())
            throw new \DomainException('Нельзя отменить');
        $tour->setStatus(StatusHelper::STATUS_INACTIVE);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            $this->loginService->admin()->getId(),
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation('ID=' . $tour->id . '&' . 'STATUS=' . StatusHelper::STATUS_INACTIVE);
        $this->dialogs->save($dialog);
        $this->contactService->sendNoticeMessage($dialog);
        $this->tours->save($tour);
    }

    public function draft(int $id)
    {
        $tour = $this->tours->get($id);
        if (!$tour->isActive())
            throw new \DomainException('Нельзя отправить в черновики');
        $tour->setStatus(StatusHelper::STATUS_DRAFT);
        $this->tours->save($tour);
    }

    public function activate(int $id)
    {
        $tour = $this->tours->get($id);
        //Активировать можно только из Черновика, или с Модерации
        if ($tour->isDraft() || $tour->isVerify()) {
            if ($tour->isVerify()) $tour->public_at = time(); //Фиксируем дату публикации
            $tour->setStatus(StatusHelper::STATUS_ACTIVE);
            $this->tours->save($tour);
        } else {
            throw new \DomainException('Нельзя активировать');
        }
    }

    public function lock(int $id)
    {
        $tour = $this->tours->get($id);
        $tour->setStatus(StatusHelper::STATUS_LOCK);
        $this->tours->save($tour);
        $this->contactService->sendLock($tour);
    }

    public function unlock(int $id)
    {
        $tour = $this->tours->get($id);
        if (!$tour->isLock())
            throw new \DomainException('Нельзя разблокировать');
        $tour->setStatus(StatusHelper::STATUS_INACTIVE);
        $this->tours->save($tour);
    }

    public function support(int $id, $type)
    {
        //TODO !!!!! отправка жалобы на заблокированный объект
    }

    public function addCostCalendar(int $id, int $tour_at, $time_at, $tickets, $cost_adult, $cost_child, $cost_preference)
    {
        /** @var Tour $tour */
        $tour = $this->tours->get($id);
        if ($tour->isPrivate() && $tickets != 1) {
            //TODO Сделать вызов исключения и отлавливать выше
            return 'Для индивидуального тура кол-во билетов должно быть равно 1';
        }

        if ($this->calendars->isset($tour->id, $tour_at, $time_at)) {
            return 'Данное время (' . $time_at . ') уже занято ';
        }
        $tour->addCostCalendar(
            CostCalendar::create(
                $tour_at,
                $time_at,
                new Cost($cost_adult, $cost_child, $cost_preference),
                $tickets
            )
        );
        $this->tours->save($tour);
    }

    public function upViews(Tour $tour)
    {
        $tour->upViews();
        $this->tours->save($tour);
    }

    public function setMeta($id, MetaForm $form)
    {
        $tour = $this->tours->get($id);
        $tour->setMeta(new Meta($form->title, $form->description, $form->keywords));
        $this->tours->save($tour);
    }

    /** FILLING */

    public function next_filling(Tour $tour)
    {
        if ($tour->filling == null) return null;
        $next = [
            Filling::COMMON => Filling::PHOTOS,
            Filling::PHOTOS => Filling::PARAMS,
            Filling::PARAMS => Filling::EXTRA,
            Filling::EXTRA => Filling::FINANCE,
            Filling::FINANCE => Filling::CALENDAR,
            Filling::CALENDAR => null,
        ];
        $tour->filling = $next[$tour->filling];
        $this->tours->save($tour);
        return $this->redirect_filling($tour);
    }

    public function redirect_filling(Tour $tour)
    {
        if ($tour->filling == null) return null;
        $redirect = [
            Filling::COMMON => ['/tour/common/create', 'id' => $tour->id],
            Filling::PHOTOS => ['/tour/photos/index', 'id' => $tour->id],
            Filling::PARAMS => ['/tour/params/update', 'id' => $tour->id],
            Filling::EXTRA => ['/tour/extra/index', 'id' => $tour->id],
            Filling::FINANCE => ['/tour/finance/update', 'id' => $tour->id],
            Filling::CALENDAR => ['/tour/calendar/index', 'id' => $tour->id],
        ];
        return $redirect[$tour->filling];
    }

    public function setExtraTime(int $user_id, \booking\forms\booking\tours\ExtraTimeForm $form): int
    {
        $tours = $this->tours->getByUser($user_id);
        /** @var Tour $tour */
        foreach ($tours as $tour) {
            $tour->setExtraTime($form->extra_time_cost, $form->extra_time_max);
            $this->tours->save($tour);
        }
        return count($tours);
    }

    public function setCapacity($user_id, $id)
    {
        $tours = $this->tours->getByUser($user_id);
        /** @var Tour $tour */
        foreach ($tours as $tour) {
            $tour->assignCapacity($id);
            $this->tours->save($tour);
        }
        return count($tours);
    }

}