<?php


namespace booking\services\foods;


use booking\entities\booking\funs\WorkMode;
use booking\entities\foods\Food;
use booking\entities\foods\InfoAddress;
use booking\entities\foods\Photo;
use booking\entities\foods\ReviewFood;
use booking\entities\Meta;
use booking\forms\admin\ContactAssignmentForm;
use booking\forms\booking\funs\WorkModeForm;
use booking\forms\booking\PhotosForm;
use booking\forms\foods\ContactAssignForm;
use booking\forms\foods\FoodForm;
use booking\forms\foods\InfoAddressForm;
use booking\forms\foods\ReviewFoodForm;
use booking\helpers\scr;
use booking\repositories\foods\FoodRepository;
use booking\services\ImageService;

class FoodService
{
    /**
     * @var FoodRepository
     */
    private $foods;

    public function __construct(FoodRepository $foods)
    {
        $this->foods = $foods;
    }

    public function create(FoodForm $form): Food
    {
        $food = Food::create($form->name, $form->description);
        foreach ($form->kitchens as $kitchen) {
            $food->assignKitchen($kitchen);
        }

        foreach ($form->categories as $category) {
            $food->assignCategory($category);
        }
        $food->setMeta(new Meta(
            $food->meta->title,
            $food->meta->description,
            $food->meta->keywords
        ));
        $food->setWorkMode(array_map(function (WorkModeForm $modeForm) {
            return new WorkMode(
                $modeForm->day_begin,
                $modeForm->day_end,
                $modeForm->break_begin,
                $modeForm->break_end
            );
        }, $form->workModes));
        $this->foods->save($food);
        return $food;
    }

    public function edit($id, FoodForm $form): void
    {
        $food = $this->foods->get($id);
        $food->edit($form->name, $form->description);
        $food->clearKitchen();
        $food->clearCategory();
        $this->foods->save($food);

        foreach ($form->kitchens as $kitchen) {
            $food->assignKitchen($kitchen);
        }

        foreach ($form->categories as $category) {
            $food->assignCategory($category);
        }
        $food->setMeta(new Meta(
            $form->meta->title,
            $form->meta->description,
            $form->meta->keywords
        ));
        $food->setWorkMode(array_map(function (WorkModeForm $modeForm) {
            return new WorkMode(
                $modeForm->day_begin,
                $modeForm->day_end,
                $modeForm->break_begin,
                $modeForm->break_end
            );
        }, $form->workModes));
        $this->foods->save($food);
    }

    public function visible($id): void
    {
        $food = $this->foods->get($id);
        $food->visible = !$food->visible;
        $this->foods->save($food);

    }

    public function addPhotos($id, PhotosForm $form): void
    {
        $food = $this->foods->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $food->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
        ini_set('max_execution_time', 180);
        $this->foods->save($food);
        ini_set('max_execution_time', 30);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $food = $this->foods->get($id);
        $food->movePhotoUp($photoId);
        $this->foods->save($food);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $food = $this->foods->get($id);
        $food->movePhotoDown($photoId);
        $this->foods->save($food);
    }

    public function removePhoto($id, $photoId): void
    {
        $food = $this->foods->get($id);
        $food->removePhoto($photoId);
        $this->foods->save($food);
    }

    public function addContact($id, ContactAssignForm $form): void
    {
        $food = $this->foods->get($id);
        $food->addContact(
            $form->contact_id,
            $form->value,
            $form->description
        );
        $this->foods->save($food);
    }

    public function updateContact($id, $contact_id, ContactAssignForm $form)
    {
        $food = $this->foods->get($id);
        $food->updateContact(
            $contact_id,
            $form->value,
            $form->description
        );
        $this->foods->save($food);
    }

    public function removeContact($id, $contact_id)
    {
        $food = $this->foods->get($id);
        $food->removeContact($contact_id);
        $this->foods->save($food);
    }

    public function addAddress(int $id, InfoAddressForm $form)
    {
        $food = $this->foods->get($id);
        $food->addAddress(InfoAddress::create(
            $form->phone,
            $form->city,
            $form->address,
            $form->latitude,
            $form->longitude,
        ));
        $this->foods->save($food);
    }

    public function removeAddress(int $id, $address_id)
    {
        $food = $this->foods->get($id);
        $food->removeAddress($address_id);
        $this->foods->save($food);
    }

    public function addReview($tour_id, ReviewFoodForm $form)
    {
        $food = $this->foods->get($tour_id);
        $food->addReview(ReviewFood::create($form->vote, $form->text, $form->username, $form->email));
        $this->foods->save($food);
    }

}