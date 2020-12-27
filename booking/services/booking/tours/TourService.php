<?php

namespace booking\services\booking\tours;

use booking\entities\booking\BookingAddress;
use booking\entities\booking\AgeLimit;
use booking\entities\booking\tours\Cost;
use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\TourParams;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\ReviewForm;
use booking\forms\booking\tours\CostForm;
use booking\forms\booking\tours\TourCommonForm;
use booking\forms\booking\tours\TourExtraForm;
use booking\forms\booking\tours\TourFinanceForm;
use booking\forms\booking\tours\TourParamsForm;
use booking\helpers\BookingHelper;
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

    public function __construct(
        TourRepository $tours,
        TransactionManager $transaction,
        TypeRepository $types,
        ExtraRepository $extra,
        ContactService $contactService,
        ReviewTourRepository $reviews,
        DialogRepository $dialogs,
        CostCalendarRepository $calendars
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
    }

    public function create(TourCommonForm $form): Tour
    {
        $tour = Tour::create(
            $form->name,
            $form->types->main,
            $form->description,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            ),
            $form->name_en,
            $form->description_en
        );
        foreach ($form->types->others as $otherId) {
            $type = $this->types->get($otherId);
            $tour->assignType($type->id);
        }
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
            $form->description_en
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
        //echo '<pre>';var_dump($form); exit();
        $tour = $this->tours->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $tour->addPhoto($file);
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
        $review =$tour->addReview($user_id, $form->vote, $form->text);
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
        $this->tours->save($tour);
    }

    public function setExtra($id, $extra_id, $set /*ToursExtraForm $form*/): void
    {

        $tour = $this->tours->get($id);
        echo $id . $extra_id . $set;
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
        //По умолчанию ч/з подтверждение
        $tour->setCheckBooking(!empty($form->check_booking) ? $form->check_booking : BookingHelper::BOOKING_CONFIRMATION);
        //По умолчанию комиссия на Провайдере
        $tour->setPayBank($form->pay_bank ?? true);
        $tour->setCancellation(($form->cancellation == '') ? null : $form->cancellation);
        $this->tours->save($tour);
    }



    public function save(Tour $tours)
    {
        throw new \DomainException('ОШИБКА!!!!!!!!!!!!!!!!!!!!! БЛЯДЬ ОТКУДА!!!!!!!!!!!!!!!!!!!!11');
    }

    public function verify($id)
    {
        $tour = $this->tours->get($id);
        if (!$tour->isInactive())
            throw new \DomainException('Нельзя отправить на модерацию');
        $tour->setStatus(StatusHelper::STATUS_VERIFY);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            \Yii::$app->user->id,
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation(Tour::class . ' ID=' . $tour->id . '&'. 'STATUS=' . StatusHelper::STATUS_VERIFY);
        $this->dialogs->save($dialog);
        $this->contactService->sendActivate($tour);
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
            \Yii::$app->user->id,
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation('ID=' . $tour->id . '&'. 'STATUS=' . StatusHelper::STATUS_INACTIVE);
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
        $this->contactService->sendLockTour($tour);
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
            return 'Для индивидуального тура кол-во билетов должно быть равно 1';
        }

        if ($this->calendars->isset($tour->id, $tour_at, $time_at))
        {
            return 'Данное время (' . $time_at . ') уже занято ';
        }
        $tour->addCostCalendar(
            $tour_at,
            $time_at,
            $tickets,
            $cost_adult,
            $cost_child,
            $cost_preference
        );
        $this->tours->save($tour);
    }

}