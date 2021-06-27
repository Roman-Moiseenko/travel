<?php

namespace booking\services\booking\trips;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\trips\placement\Photo;
use booking\entities\booking\trips\placement\Placement;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\trips\MealsForm;
use booking\forms\booking\trips\PlacementForm;
use booking\helpers\StatusHelper;
use booking\repositories\booking\trips\placement\PlacementRepository;
use booking\repositories\booking\trips\placement\TypeRepository;
use booking\services\ImageService;
use booking\services\system\LoginService;
use booking\services\TransactionManager;

class PlacementService
{


    /**
     * @var PlacementRepository
     */
    private $placements;
    /**
     * @var TypeRepository
     */
    private $types;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        PlacementRepository $placements,
        TypeRepository $types,
        LoginService $loginService
    )
    {
        $this->placements = $placements;
        $this->types = $types;
        $this->loginService = $loginService;
    }

    public function create(PlacementForm $form): Placement
    {
        $placement = Placement::create(
            $this->loginService->admin()->getId(),
            $form->type_id,
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );
        foreach ($form->assignComforts as $item) {
            if ($item->checked) {
                $placement->addComfort($item->comfort_id);
            } else {
                $placement->revokeComfort($item->comfort_id);
            }
        }
        $this->placements->save($placement);
        return $placement;
    }

    public function edit($id, PlacementForm $form): void
    {
        $placement = $this->placements->get($id);
        $placement->edit(
            $form->type_id,
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );
        foreach ($form->assignComforts as $item) {
            if ($item->checked) {
                $placement->addComfort($item->comfort_id);
            } else {
                $placement->revokeComfort($item->comfort_id);
            }
        }
        $this->placements->save($placement);
    }

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

    public function assignMeals($id, MealsForm $form)
    {
        $placement = $this->placements->get($id);
        $placement->revokeMeals();
        $this->placements->save($placement);
        if ($form->not_meals) return;
        foreach ($form->meals as $meal) {
            $placement->assignMeal($meal->id(), $meal->cost);
        }
        $this->placements->save($placement);
    }

    //TODO Rooms
}