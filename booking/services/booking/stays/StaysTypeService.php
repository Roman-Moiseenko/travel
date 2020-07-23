<?php


namespace booking\services\booking\stays;


use booking\entities\booking\stays\StaysType;
use booking\forms\booking\stays\StaysTypeForm;
use booking\repositories\booking\stays\StaysTypeRepository;

class StaysTypeService
{
    private $staysType;

    public function __construct(StaysTypeRepository $staysType)
    {
        $this->staysType = $staysType;
    }

    public function create(StaysTypeForm $form): StaysType
    {
        $staysType = StaysType::create($form->name, $form->mono);
        $this->staysType->save($staysType);
        return $staysType;
    }

    public function edit($id, StaysTypeForm $form): void
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