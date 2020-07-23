<?php


namespace booking\services\booking\rooms;


use booking\entities\booking\rooms\RoomsType;
use booking\forms\booking\rooms\RoomsTypeForm;
use booking\repositories\booking\rooms\RoomsTypeRepository;

class RoomsTypeService
{
    private $roomsType;

    public function __construct(RoomsTypeRepository $roomsType)
    {
        $this->roomsType = $roomsType;
    }

    public function create(RoomsTypeForm $form): RoomsType
    {
        $roomsType = RoomsType::create($form->stays_id, $form->name);
        $this->roomsType->save($roomsType);
        return $roomsType;
    }

    public function edit($id, RoomsTypeForm $form): void
    {
        $roomsType = $this->roomsType->get($id);
        $roomsType->edit($form->stays_id, $form->name);
        $this->roomsType->save($roomsType);
    }

    public function remove($id): void
    {
        $roomsType = $this->roomsType->get($id);
        $this->roomsType->remove($roomsType);
    }
}