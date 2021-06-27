<?php


namespace booking\services\office\guides;


use booking\entities\booking\trips\placement\Type;
use booking\forms\office\guides\PlacementTypeForm;
use booking\repositories\booking\trips\placement\TypeRepository;

class TypePlacementService
{
    private $toursType;

    public function __construct(TypeRepository $toursType)
    {
        $this->toursType = $toursType;
    }

    public function create(PlacementTypeForm $form): Type
    {
        $tourType = Type::create($form->name);
        $this->toursType->save($tourType);
        return $tourType;
    }

    public function edit($id, PlacementTypeForm $form): void
    {
        $tourType = $this->toursType->get($id);
        $tourType->edit($form->name);
        $this->toursType->save($tourType);
    }

    public function remove($id): void
    {
        $tourType = $this->toursType->get($id);
        $this->toursType->remove($tourType);
    }
}