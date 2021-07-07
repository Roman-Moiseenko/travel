<?php

namespace booking\services\booking\trips;


use booking\entities\booking\AgeLimit;
use booking\entities\booking\trips\CostCalendar;
use booking\entities\booking\trips\CostList;
use booking\entities\booking\trips\CostParams;
use booking\entities\booking\trips\Photo;
use booking\entities\booking\trips\ReviewTrip;
use booking\entities\booking\trips\Trip;
use booking\entities\booking\trips\TripParams;
use booking\entities\booking\trips\Video;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\entities\Meta;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\ReviewForm;
use booking\forms\booking\trips\TripCommonForm;
use booking\forms\booking\trips\TripFinanceForm;
use booking\forms\booking\trips\TripParamsForm;
use booking\forms\booking\VideosForm;
use booking\forms\MetaForm;
use booking\helpers\Filling;
use booking\helpers\StatusHelper;
use booking\repositories\booking\trips\CostCalendarRepository;
use booking\repositories\booking\trips\ReviewTripRepository;
use booking\repositories\booking\trips\TripRepository;
use booking\repositories\booking\trips\TypeRepository;
use booking\repositories\message\DialogRepository;
use booking\services\ContactService;
use booking\services\ImageService;
use booking\services\system\LoginService;
use booking\services\TransactionManager;

class TripService
{

    /**
     * @var TripRepository
     */
    private $trips;
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
     * @var ReviewTripRepository
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
    /**
     * @var CostCalendarRepository
     */
    private $calendars;

    public function __construct(
        TripRepository $trips,
        TransactionManager $transaction,
        TypeRepository $types,
        ContactService $contactService,
        ReviewTripRepository $reviews,
        DialogRepository $dialogs,
        CostCalendarRepository $calendars,
        LoginService $loginService
    )
    {
        $this->trips = $trips;
        $this->transaction = $transaction;
        $this->types = $types;
        $this->contactService = $contactService;
        $this->reviews = $reviews;
        $this->dialogs = $dialogs;
        $this->loginService = $loginService;
        $this->calendars = $calendars;
    }

    public function create(TripCommonForm $form): Trip
    {
        $trip = Trip::create(
            $this->loginService->admin()->getId(),
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->types->main,
            $form->slug
        );
        foreach ($form->types->others as $otherId) {
            $type = $this->types->get($otherId);
            $trip->assignType($type->id);
        }
        $trip->filling = Filling::COMMON;
        $this->trips->save($trip);
        return $trip;
    }

    public function edit($id, TripCommonForm $form): void
    {
        $trip = $this->trips->get($id);
        $trip->edit(
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->types->main,
            $form->slug
        );
        $this->transaction->wrap(function () use ($form, $trip) {
            $trip->clearType();
            $this->trips->save($trip);
            foreach ($form->types->others as $otherId) {
                $type = $this->types->get($otherId);
                $trip->assignType($type->id);
            }
            $this->trips->save($trip);
        });
    }

    public function setFinance(int $id, TripFinanceForm $form)
    {
        $trip = $this->trips->get($id);
        $trip->setLegal($form->legal_id);
        $trip->setCost($form->cost_base);
        $trip->setPrepay($form->prepay);
        $trip->setCancellation(($form->cancellation == '') ? null : $form->cancellation);
        $this->trips->save($trip);
    }

//***** AssignPlacement
    public function assignPlacement($id, $placement_id)
    {
        $trip = $this->trips->get($id);
        $trip->assignPlacement($placement_id);
        $this->trips->save($trip);
    }

    public function revokePlacement($id, $placement_id)
    {
        $trip = $this->trips->get($id);
        $trip->revokePlacement($placement_id);
        $this->trips->save($trip);
    }

//***** Video

    public function addVideo($id, VideosForm $form)
    {
        $trip = $this->trips->get($id);
        $trip->addVideo(Video::create(
            $form->caption,
            $form->url,
            $form->caption_en,
            $form->type_hosting
        ));
        $this->trips->save($trip);
    }

    public function editVideo($id, $video_id, VideosForm $form)
    {
        $trip = $this->trips->get($id);
        $trip->editVideo(
            $video_id,
            Video::create(
                $form->caption,
                $form->url,
                $form->caption_en,
                $form->type_hosting
            )
        );
        $this->trips->save($trip);
    }

    public function moveVideoUp($id, $video_id): void
    {
        $trip = $this->trips->get($id);
        $trip->moveVideoUp($video_id);
        $this->trips->save($trip);
    }

    public function moveVideoDown($id, $video_id): void
    {
        $trip = $this->trips->get($id);
        $trip->moveVideoDown($video_id);
        $this->trips->save($trip);
    }

    public function removeVideo($id, $video_id): void
    {
        $trip = $this->trips->get($id);
        $trip->removeVideo($video_id);
        $this->trips->save($trip);
    }

//**** Photo
    public function addPhotos($id, PhotosForm $form)
    {
        $trip = $this->trips->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $trip->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
        ini_set('max_execution_time', 180);
        $this->trips->save($trip);
        ini_set('max_execution_time', 30);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $trip = $this->trips->get($id);
        $trip->movePhotoUp($photoId);
        $this->trips->save($trip);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $trip = $this->trips->get($id);
        $trip->movePhotoDown($photoId);
        $this->trips->save($trip);
    }

    public function removePhoto($id, $photoId): void
    {
        $trip = $this->trips->get($id);
        $trip->removePhoto($photoId);
        $this->trips->save($trip);
    }

    public function addReview($trip_id, $user_id, ReviewForm $form)
    {
        $trip = $this->trips->get($trip_id);
        $review = $trip->addReview(ReviewTrip::create($user_id, $form->vote, $form->text));
        $this->trips->save($trip);
        $this->contactService->sendNoticeReview($review);
    }

    public function removeReview($review_id)
    {
        $review = $this->reviews->get($review_id);
        $trip = $this->trips->get($review->trip_id);
        $trip->removeReview($review_id);
        $this->trips->save($trip);
    }

    public function editReview($review_id, ReviewForm $form)
    {
        $review = $this->reviews->get($review_id);
        $trip = $this->trips->get($review->trip);
        $trip->editReview($review_id, $form->vote, $form->text);
        $this->trips->save($trip);
    }

    public function setParams($id, TripParamsForm $form): void
    {
        $trip = $this->trips->get($id);
        $trip->setParams(
            new TripParams(
                $form->duration,
                $form->transfer,
                $form->capacity,
            )
        );
        $this->trips->save($trip);
    }

    /*
            public function setFinance($id, TripFinanceForm $form): void
            {
                $trip = $this->trips->get($id);
                $trip->setLegal($form->legal_id);
                $trip->setCost(
                    new Cost(
                        $form->baseCost->adult,
                        $form->baseCost->child,
                        $form->baseCost->preference
                    )
                );
                $trip->setPrepay($form->prepay);
                $trip->setCancellation(($form->cancellation == '') ? null : $form->cancellation);
                $trip->setExtraTime($form->extra_time_cost, $form->extra_time_max);
                $trip->clearCapacity();
                $trip->clearTransfer();
                $this->trips->save($trip);
                foreach ($form->capacities as $capacity_id)
                    $trip->assignCapacity($capacity_id);
                foreach ($form->transfers as $transfer_id)
                    $trip->assignTransfer($transfer_id);
                $this->trips->save($trip);
            }
        */
    public function verify($id)
    {
        $trip = $this->trips->get($id);
        if (!$trip->isInactive())
            throw new \DomainException('Нельзя отправить на модерацию');

        if ($trip->mainPhoto == null) {
            throw new \DomainException('Вы не добавили ни одной фотографии!');
        }

        $trip->setStatus(StatusHelper::STATUS_VERIFY);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            $this->loginService->admin()->getId(),
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation(Trip::class . ' ID=' . $trip->id . '&' . 'STATUS=' . StatusHelper::STATUS_VERIFY);
        $this->dialogs->save($dialog);
        $this->contactService->sendActivate($trip->name, $trip->user->username);
        $this->trips->save($trip);
    }

    public function cancel(int $id)
    {
        $trip = $this->trips->get($id);
        if (!$trip->isVerify())
            throw new \DomainException('Нельзя отменить');
        $trip->setStatus(StatusHelper::STATUS_INACTIVE);
        $dialog = Dialog::create(
            null,
            Dialog::PROVIDER_SUPPORT,
            $this->loginService->admin()->getId(),
            ThemeDialog::ACTIVATED,
            ''
        );
        $dialog->addConversation('ID=' . $trip->id . '&' . 'STATUS=' . StatusHelper::STATUS_INACTIVE);
        $this->dialogs->save($dialog);
        $this->contactService->sendNoticeMessage($dialog);
        $this->trips->save($trip);
    }

    public function draft(int $id)
    {
        $trip = $this->trips->get($id);
        if (!$trip->isActive())
            throw new \DomainException('Нельзя отправить в черновики');
        $trip->setStatus(StatusHelper::STATUS_DRAFT);
        $this->trips->save($trip);
    }

    public function activate(int $id)
    {
        $trip = $this->trips->get($id);
        //Активировать можно только из Черновика, или с Модерации
        if ($trip->isDraft() || $trip->isVerify()) {
            if ($trip->isVerify()) $trip->public_at = time(); //Фиксируем дату публикации
            $trip->setStatus(StatusHelper::STATUS_ACTIVE);
            $this->trips->save($trip);
        } else {
            throw new \DomainException('Нельзя активировать');
        }
    }

    public function lock(int $id)
    {
        $trip = $this->trips->get($id);
        $trip->setStatus(StatusHelper::STATUS_LOCK);
        $this->trips->save($trip);
        $this->contactService->sendLock($trip);
    }

    public function unlock(int $id)
    {
        $trip = $this->trips->get($id);
        if (!$trip->isLock())
            throw new \DomainException('Нельзя разблокировать');
        $trip->setStatus(StatusHelper::STATUS_INACTIVE);
        $this->trips->save($trip);
    }

    public function addCostCalendar($trip_id, $trip_at, $cost_base, $quantity, array $params, array $cost_list)
    {
        $trip = $this->trips->get($trip_id);
        if ($this->calendars->isset($trip->id, $trip_at)) {
            return 'На данный день (' . date('d-m-Y', $trip_at) . ') уже внесен этот тур ';
        }

        $calendar = CostCalendar::create(
            $trip_at,
            $cost_base,
            $quantity
        );
        //print_r($params);
        foreach ($params as $param) {
            $calendar->addParams(new CostParams($param['params'], $param['cost']));
        }
        foreach ($cost_list as $item) {
            $calendar->addCost(new CostList($item['class'], $item['id'], $item['cost']));
        }

        $trip->addCostCalendar($calendar);
        $this->trips->save($trip);
    }

    public function support(int $id, $type)
    {
        //TODO !!!!! отправка жалобы на заблокированный объект
    }

    /*
        public function addCostCalendar(int $id, int $trip_at, $time_at, $tickets, $cost_adult, $cost_child, $cost_preference)
        {

            $trip = $this->trips->get($id);


            if ($this->calendars->isset($trip->id, $trip_at, $time_at)) {
                return 'Данное время (' . $time_at . ') уже занято ';
            }
            $trip->addCostCalendar(
                CostCalendar::create(
                    $trip_at,
                    $time_at,
                    new Cost($cost_adult, $cost_child, $cost_preference),
                    $tickets
                )
            );
            $this->trips->save($trip);
        }*/

    public function upViews(Trip $trip)
    {
        $trip->upViews();
        $this->trips->save($trip);
    }

    public function setMeta($id, MetaForm $form)
    {
        $trip = $this->trips->get($id);
        $trip->setMeta(new Meta($form->title, $form->description, $form->keywords));
        $this->trips->save($trip);
    }

    /** FILLING */

    public function next_filling(Trip $trip)
    {
        if ($trip->filling == null) return null;
        $next = [
            Filling::COMMON => Filling::PHOTOS,
            Filling::PHOTOS => Filling::VIDEOS,
            Filling::VIDEOS => Filling::PARAMS,
            Filling::PARAMS => Filling::PLACEMENT,
            Filling::PLACEMENT => Filling::ACTIVITY,
            Filling::ACTIVITY => Filling::FINANCE,
            Filling::FINANCE => Filling::CALENDAR,
            Filling::CALENDAR => null,
        ];
        $trip->filling = $next[$trip->filling];
        $this->trips->save($trip);
        return $this->redirect_filling($trip);
    }

    public function redirect_filling(Trip $trip)
    {
        if ($trip->filling == null) return null;
        $redirect = [
            Filling::COMMON => ['/trip/common/create', 'id' => $trip->id],
            Filling::PHOTOS => ['/trip/photos/index', 'id' => $trip->id],
            Filling::VIDEOS => ['/trip/videos/index', 'id' => $trip->id],
            Filling::PARAMS => ['/trip/params/update', 'id' => $trip->id],
            Filling::PLACEMENT => ['/trip/placement/index', 'id' => $trip->id],
            Filling::ACTIVITY => ['/trip/activity/index', 'id' => $trip->id],
            Filling::FINANCE => ['/trip/finance/update', 'id' => $trip->id],
            Filling::CALENDAR => ['/trip/calendar/index', 'id' => $trip->id],
        ];
        return $redirect[$trip->filling];
    }




}