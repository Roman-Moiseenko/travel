<?php


namespace booking\services\office\guides;


use booking\entities\booking\cars\Characteristic;
use booking\entities\booking\cars\Type;
use booking\forms\booking\cars\CharacteristicForm;
use booking\forms\office\guides\CarTypeForm;
use booking\repositories\booking\cars\TypeRepository;

class TypeCarService
{
    private $carsType;

    public function __construct(TypeRepository $carsType)
    {
        $this->carsType = $carsType;
    }

    public function create(CarTypeForm $form): Type
    {
        $carType = Type::create($form->name, $form->slug);
        $sort = $this->carsType->getMaxSort();
        $carType->setSort($sort + 1);
        $this->carsType->save($carType);
        return $carType;
    }

    public function edit($id, CarTypeForm $form): void
    {
        $carType = $this->carsType->get($id);
        $carType->edit($form->name, $form->slug);
        $this->carsType->save($carType);
    }

    public function addCharacteristic($id, CharacteristicForm $form)
    {
        $carType = $this->carsType->get($id);
        $carType->addCharacteristic(
            Characteristic::create(
                $form->name,
                $form->type_variable,
                $form->required,
                $form->default,
                $form->variants,
                $form->sort
            )
        );
        $this->carsType->save($carType);
    }


    public function moveUp($id)
    {
        $types = $this->carsType->getAll();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != 0) {
                $t1 = $types[$i - 1];
                $t2 = $type;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->carsType->save($t1);
                $this->carsType->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $types = $this->carsType->getAll();
        $maxSort = $this->carsType->getMaxSort();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != count($types) - 1) {
                $t1 = $type;
                $t2 = $types[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->carsType->save($t1);
                $this->carsType->save($t2);
                return;
            }
        }
    }

    public function remove($id): void
    {
        $carType = $this->carsType->get($id);
        $this->carsType->remove($carType);
    }

    public function updateCharacteristic(int $type_car_id, int $id, CharacteristicForm $form)
    {
        $carType = $this->carsType->get($type_car_id);
        $carType->updateCharacteristic(
            $id,
            $form->name,
            $form->type_variable,
            $form->required,
            $form->default,
            $form->variants,
            $form->sort
        );
        $this->carsType->save($carType);
    }

    public function removeCharacteristic(int $type_car_id, int $id)
    {
        $carType = $this->carsType->get($type_car_id);
        $carType->removeCharacteristic($id);
        $this->carsType->save($carType);
    }
}