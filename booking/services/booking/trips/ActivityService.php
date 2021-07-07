<?php


namespace booking\services\booking\trips;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\trips\activity\Activity;
use booking\entities\booking\trips\activity\Photo;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\trips\ActivityForm;
use booking\repositories\booking\trips\ActivityRepository;
use booking\services\ImageService;

class ActivityService
{
    /**
     * @var ActivityRepository
     */
    private $activities;

    public function __construct(ActivityRepository $activities)
    {
        $this->activities = $activities;
    }

    public function create(int $id, ActivityForm $form)
    {
        $activity = Activity::create(
            $id,
            $form->day,
            $form->time,
            $form->caption,
            $form->caption_en,
            $form->description,
            $form->description_en,
            $form->cost,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );
        if ($form->photos->files != null)
            foreach ($form->photos->files as $file) {
                $activity->addPhoto(Photo::create($file));
            }

        $this->activities->save($activity);
    }


    public function edit($id, ActivityForm $form)
    {
        $activity = $this->activities->get($id);
        $activity->edit(
            $form->day,
            $form->time,
            $form->caption,
            $form->caption_en,
            $form->description,
            $form->description_en,
            $form->cost,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );
        if ($form->photos->files != null)
            foreach ($form->photos->files as $file) {
                $activity->addPhoto(Photo::create($file));
            }
        $this->activities->save($activity);
    }


    public function delete($id)
    {
        $activity = $this->activities->get($id);
        $this->activities->remove($activity);
    }

    //**** Photo
    public function addPhotos($id, PhotosForm $form)
    {
        $activity = $this->activities->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $activity->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
        ini_set('max_execution_time', 180);
        $this->activities->save($activity);
        ini_set('max_execution_time', 30);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $activity = $this->activities->get($id);
        $activity->movePhotoUp($photoId);
        $this->activities->save($activity);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $activity = $this->activities->get($id);
        $activity->movePhotoDown($photoId);
        $this->activities->save($activity);
    }

    public function removePhoto($id, $photoId): void
    {
        $activity = $this->activities->get($id);
        $activity->removePhoto($photoId);
        $this->activities->save($activity);
    }
}