<?php

namespace booking\services\booking\tours;

use booking\entities\booking\BookingAddress;
use booking\entities\booking\stays\rules\AgeLimit;
use booking\entities\booking\tours\Cost;
use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\TourParams;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\ReviewForm;
use booking\forms\booking\tours\CostForm;
use booking\forms\booking\tours\ToursCommonForms;
use booking\forms\booking\tours\ToursExtraForm;
use booking\forms\booking\tours\ToursFinanceForm;
use booking\forms\booking\tours\ToursParamsForm;
use booking\repositories\booking\tours\ExtraRepository;
use booking\repositories\booking\tours\ReviewTourRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\repositories\booking\tours\TypeRepository;
use booking\repositories\booking\ReviewRepository;
use booking\services\ContactService;
use booking\services\TransactionManager;

class TourService
{
    private $tours;
    private $transaction;
    private $types;
    private $extra;
    private $contactService;
    private $reviews;

    public function __construct(
        TourRepository $tours,
        TransactionManager $transaction,
        TypeRepository $types,
        ExtraRepository $extra,
        ContactService $contactService,
        ReviewTourRepository $reviews
    )
    {
        $this->tours = $tours;
        $this->transaction = $transaction;
        $this->types = $types;
        $this->extra = $extra;
        $this->contactService = $contactService;
        $this->reviews = $reviews;
    }

    public function create(ToursCommonForms $form): Tour
    {
        $tours = Tour::create(
            $form->name,
            $form->types->main,
            $form->description,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );

        foreach ($form->types->others as $otherId) {
            $type = $this->types->get($otherId);
            $tours->assignType($type->id);
        }
        $this->tours->save($tours);

        return $tours;
    }

    public function edit($id, ToursCommonForms $form): void
    {
        $tours = $this->tours->get($id);
        $tours->edit(
            $form->name,
            $form->types->main,
            $form->description,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );
        $this->transaction->wrap(function () use ($form, $tours) {
            $tours->clearType();
            $this->tours->save($tours);
            foreach ($form->types->others as $otherId) {
                $type = $this->types->get($otherId);
                $tours->assignType($type->id);
            }
            $this->tours->save($tours);
        });

    }

    public function addPhotos($id, PhotosForm $form)
    {
        //echo '<pre>';var_dump($form); exit();
        $tours = $this->tours->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $tours->addPhoto($file);
            }
        $this->tours->save($tours);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $tours = $this->tours->get($id);
        $tours->movePhotoUp($photoId);
        $this->tours->save($tours);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $tours = $this->tours->get($id);
        $tours->movePhotoDown($photoId);
        $this->tours->save($tours);
    }

    public function removePhoto($id, $photoId): void
    {
        $tours = $this->tours->get($id);
        $tours->removePhoto($photoId);
        $this->tours->save($tours);
    }

    public function addReview($tours_id, $user_id, ReviewForm $form)
    {
        $tours = $this->tours->get($tours_id);
        $review =$tours->addReview($user_id, $form->vote, $form->text);
        $this->tours->save($tours);
        $this->contactService->sendNoticeReview($review);
    }

    public function removeReview($review_id)
    {
        $review = $this->reviews->get($review_id);
        $tours = $this->tours->get($review->tours_id);
        $tours->removeReview($review_id);
        $this->tours->save($tours);
    }

    public function editReview($review_id, ReviewForm $form)
    {
        $review = $this->reviews->get($review_id);
        $tours = $this->tours->get($review->tours_id);
        $tours->editReview($review_id, $form->vote, $form->text);
        $this->tours->save($tours);
    }

    public function setParams($id, ToursParamsForm $form): void
    {
        $tours = $this->tours->get($id);
        $tours->setParams(
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
        $this->tours->save($tours);
    }

    public function setExtra($id, $extra_id, $set /*ToursExtraForm $form*/): void
    {

        $tours = $this->tours->get($id);
        echo $id . $extra_id . $set;
        if ($set) {
            $tours->assignExtra($extra_id);
        } else {
            $tours->revokeExtra($extra_id);
        }
        $this->tours->save($tours);
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

    public function setFinance($id, ToursFinanceForm $form): void
    {
        $tours = $this->tours->get($id);
        $tours->setLegal($form->legal_id);
        $tours->setCost(
            new Cost(
                $form->baseCost->adult,
                $form->baseCost->child,
                $form->baseCost->preference
            )
        );
        $tours->setCancellation(($form->cancellation == '') ? null : $form->cancellation);
        $this->tours->save($tours);
    }





    public function save(Tour $tours)
    {
        throw new \DomainException('ОШИБКА!!!!!!!!!!!!!!!!!!!!! БЛЯДЬ ОТКУДА!!!!!!!!!!!!!!!!!!!!11');
    }


}