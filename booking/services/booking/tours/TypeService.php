<?php


namespace booking\services\booking\tours;


use booking\entities\booking\tours\Type;
use booking\forms\booking\tours\ToursTypeForm;
use booking\repositories\booking\tours\TypeRepository;

class TypeService
{
    private $toursType;

    public function __construct(TypeRepository $toursType)
    {
        $this->toursType = $toursType;
    }

    public function create(ToursTypeForm $form): Type
    {
        $toursType = Type::create($form->name);
        $this->toursType->save($toursType);
        return $toursType;
    }

    public function edit($id, ToursTypeForm $form): void
    {
        $toursType = $this->toursType->get($id);
        $toursType->edit($form->name);
        $this->toursType->save($toursType);
    }

    public function remove($id): void
    {
        $staysType = $this->toursType->get($id);
        $this->toursType->remove($staysType);
    }
}