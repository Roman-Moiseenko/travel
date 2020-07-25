<?php


namespace booking\services\booking\tours;


use booking\entities\booking\tours\Type;
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
        $staysType = Type::create($form->name, $form->mono);
        $this->staysType->save($staysType);
        return $staysType;
    }

    public function edit($id, ToursTypeForm $form): void
    {
        $staysType = $this->staysType->get($id);
        $staysType->edit($form->name, $form->name);
        $this->staysType->save($staysType);
    }

    public function remove($id): void
    {
        $staysType = $this->staysType->get($id);
        $this->staysType->remove($staysType);
    }
}