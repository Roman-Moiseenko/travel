<?php


namespace booking\services\booking\trips;


use booking\entities\booking\trips\placement\room\Photo;
use booking\entities\booking\trips\placement\room\Room;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\trips\RoomForm;
use booking\repositories\booking\trips\placement\PlacementRepository;
use booking\repositories\booking\trips\placement\RoomRepository;
use booking\services\ImageService;

class RoomService
{
    /**
     * @var PlacementRepository
     */
    private $placements;
    /**
     * @var RoomRepository
     */
    private $rooms;

    public function __construct(PlacementRepository $placements, RoomRepository $rooms)
    {
        $this->placements = $placements;
        $this->rooms = $rooms;
    }

    public function create($id, RoomForm $form): Room
    {
        $room = Room::create(
            $id,
            $form->name,
            $form->name_en,
            $form->meals_id,
            $form->quantity,
            $form->cost,
            $form->capacity,
            $form->shared
        );
        $this->update($room, $form);
        $this->rooms->save($room);
        return $room;
    }

    public function edit($id, RoomForm $form): void
    {
        $room = $this->rooms->get($id);
        $room->edit(
            $form->name,
            $form->name_en,
            $form->meals_id,
            $form->quantity,
            $form->cost,
            $form->capacity,
            $form->shared
        );

        $this->update($room, $form);
        $this->rooms->save($room);
    }

    private function update(Room $room, RoomForm $form)
    {
        foreach ($form->assignComforts as $item) {
            if ($item->checked) {
                $room->addComfort($item->comfort_id);
            } else {
                $room->revokeComfort($item->comfort_id);
            }
        }
        if ($form->photos->files != null)
            foreach ($form->photos->files as $file) {
                $room->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
    }

    public function remove($id): void
    {
        $room = $this->rooms->get($id);
        $this->rooms->remove($room);
    }

    //**** Photo
    public function addPhotos($id, PhotosForm $form)
    {
        $room = $this->rooms->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $room->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
        ini_set('max_execution_time', 180);
        $this->rooms->save($room);
        ini_set('max_execution_time', 30);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $room = $this->rooms->get($id);
        $room->movePhotoUp($photoId);
        $this->rooms->save($room);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $room = $this->rooms->get($id);
        $room->movePhotoDown($photoId);
        $this->rooms->save($room);
    }

    public function removePhoto($id, $photoId): void
    {
        $room = $this->rooms->get($id);
        $room->removePhoto($photoId);
        $this->rooms->save($room);
    }
}