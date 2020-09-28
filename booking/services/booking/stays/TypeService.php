<?php


namespace booking\services\booking\stays;


use booking\entities\booking\stays\Type;
use booking\forms\booking\stays\StayTypeForm;
use booking\repositories\booking\stays\TypeRepository;

class TypeService
{
    private $staysType;

    public function __construct(TypeRepository $staysType)
    {
        $this->staysType = $staysType;
    }

    public function create(StayTypeForm $form): Type
    {
        $staysType = Type::create($form->name, $form->mono);
        $this->staysType->save($staysType);
        return $staysType;
    }

    public function edit($id, StayTypeForm $form): void
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