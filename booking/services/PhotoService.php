<?php


namespace booking\services;


use booking\forms\booking\PhotosForm;

trait PhotoService
{
//**** Photo
    public function addPhotos($id, PhotosForm $form)
    {
        $placement = $this->placements->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $placement->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
        ini_set('max_execution_time', 180);
        $this->placements->save($placement);
        ini_set('max_execution_time', 30);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $placement = $this->placements->get($id);
        $placement->movePhotoUp($photoId);
        $this->placements->save($placement);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $placement = $this->placements->get($id);
        $placement->movePhotoDown($photoId);
        $this->placements->save($placement);
    }

    public function removePhoto($id, $photoId): void
    {
        $placement = $this->placements->get($id);
        $placement->removePhoto($photoId);
        $this->placements->save($placement);
    }
}