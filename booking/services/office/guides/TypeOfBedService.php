<?php


namespace booking\services\office\guides;


use booking\entities\booking\stays\bedroom\TypeOfBed;
use booking\forms\office\guides\TypeOfBedForm;
use booking\repositories\booking\stays\bedroom\TypeOfBedRepository;

class TypeOfBedService
{

    /**
     * @var TypeOfBedRepository
     */
    private $typeOfBeds;

    public function __construct(TypeOfBedRepository $typeOfBeds)
    {
        $this->typeOfBeds = $typeOfBeds;
    }

    public function create(TypeOfBedForm $form): TypeOfBed
    {
        $bed = TypeOfBed::create($form->name, $form->count);
        $this->typeOfBeds->save($bed);
        return  $bed;
    }

    public function edit($id, TypeOfBedForm $form)
    {
        $bed = $this->typeOfBeds->get($id);
        $bed->edit($form->name, $form->count);
        $this->typeOfBeds->save($bed);
    }

    public function remove($id)
    {
        $bed = $this->typeOfBeds->get($id);
        $this->typeOfBeds->remove($bed);
    }
}