<?php


namespace booking\services\booking\rooms;


use booking\entities\booking\hotels\rooms\Type;
use booking\forms\booking\rooms\RoomTypeForm;
use booking\repositories\booking\hotels\TypeRepository;

class TypeService
{
    private $roomsType;

    public function __construct(TypeRepository $roomsType)
    {
        $this->roomsType = $roomsType;
    }

    public function create(RoomTypeForm $form): Type
    {
        $roomsType = Type::create($form->stays_id, $form->name);
        $this->roomsType->save($roomsType);
        return $roomsType;
    }

    public function edit($id, RoomTypeForm $form): void
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