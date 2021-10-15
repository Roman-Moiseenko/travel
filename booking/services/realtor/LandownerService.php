<?php


namespace booking\services\realtor;


use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\realtor\Landowner;
use booking\entities\realtor\Photo;
use booking\forms\booking\PhotosForm;
use booking\forms\realtor\LandownerForm;
use booking\helpers\StatusHelper;
use booking\repositories\realtor\LandownerRepository;
use booking\services\ImageService;

class LandownerService
{
    /**
     * @var LandownerRepository
     */
    private $landowners;

    public function __construct(
        LandownerRepository $landowners
    )
    {
        $this->landowners = $landowners;
    }

    public function create(LandownerForm $form): Landowner
    {
        $landowner = Landowner::create(
            $form->name,
            $form->slug,
            $form->caption,
            $form->phone,
            $form->email,
            $form->cost,
            $form->description,
            $form->distance,
            $form->count,
            $form->size,
            $form->text,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );
        $landowner->setMeta(
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->landowners->save($landowner);
        return $landowner;
    }

    public function edit($id, LandownerForm $form)
    {
        $landowner = $this->landowners->get($id);
        $landowner->edit(
            $form->name,
            $form->slug,
            $form->caption,
            $form->phone,
            $form->email,
            $form->cost,
            $form->description,
            $form->distance,
            $form->count,
            $form->size,
            $form->text,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );
        $landowner->setMeta(
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->landowners->save($landowner);
    }

    public function activate($id)
    {
        $landowner = $this->landowners->get($id);
        $landowner->setStatus(StatusHelper::STATUS_ACTIVE);
        $this->landowners->save($landowner);
    }

    public function draft($id)
    {
        $landowner = $this->landowners->get($id);
        $landowner->setStatus(StatusHelper::STATUS_INACTIVE);
        $this->landowners->save($landowner);
    }

    public function addPhotos($id, PhotosForm $form): void
    {
        $landowner = $this->landowners->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $landowner->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
        ini_set('max_execution_time', 180);
        $this->landowners->save($landowner);
        ini_set('max_execution_time', 30);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $landowner = $this->landowners->get($id);
        $landowner->movePhotoUp($photoId);
        $this->landowners->save($landowner);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $landowner = $this->landowners->get($id);
        $landowner->movePhotoDown($photoId);
        $this->landowners->save($landowner);
    }

    public function removePhoto($id, $photoId): void
    {
        $landowner = $this->landowners->get($id);
        $landowner->removePhoto($photoId);
        $this->landowners->save($landowner);
    }

    public function remove($id)
    {
        $landowner = $this->landowners->get($id);
        $this->landowners->remove($landowner);
    }

}