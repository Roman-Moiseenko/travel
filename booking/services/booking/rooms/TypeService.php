<?php


namespace booking\services\booking\rooms;


use booking\entities\booking\rooms\Type;
use booking\forms\booking\rooms\RoomsTypeForm;
use booking\repositories\booking\rooms\TypeRepository;

class TypeService
{
    private $roomsType;

    public function __construct(TypeRepository $roomsType)
    {
        $this->roomsType = $roomsType;
    }

    public function create(RoomsTypeForm $form): Type
    {
        $roomsType = Type::create($form->stays_id, $form->name);
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