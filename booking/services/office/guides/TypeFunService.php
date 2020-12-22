<?php


namespace booking\services\office\guides;


use booking\entities\booking\funs\Characteristic;
use booking\entities\booking\funs\Type;
use booking\forms\booking\funs\CharacteristicForm;
use booking\forms\office\guides\FunTypeForm;
use booking\repositories\booking\funs\TypeRepository;

class TypeFunService
{
    private $funsType;

    public function __construct(TypeRepository $funsType)
    {
        $this->funsType = $funsType;
    }

    public function create(FunTypeForm $form): Type
    {
        $funType = Type::create($form->name, $form->slug, $form->multi);
        $sort = $this->funsType->getMaxSort();
        $funType->setSort($sort + 1);
        $this->funsType->save($funType);
        return $funType;
    }

    public function edit($id, FunTypeForm $form): void
    {
        $funType = $this->funsType->get($id);
        $funType->edit($form->name, $form->slug, $form->multi);
        $this->funsType->save($funType);
    }

    public function remove($id): void
    {
        $funType = $this->funsType->get($id);
        $this->funsType->remove($funType);
    }

    public function moveUp($id)
    {
        $types = $this->funsType->getAll();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != 0) {
                $t1 = $types[$i - 1];
                $t2 = $type;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->funsType->save($t1);
                $this->funsType->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $types = $this->funsType->getAll();
        $maxSort = $this->funsType->getMaxSort();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != count($types) - 1) {
                $t1 = $type;
                $t2 = $types[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->funsType->save($t1);
                $this->funsType->save($t2);
                return;
            }
        }
    }

    /** =>  Characteristic */

    public function addCharacteristic($id, CharacteristicForm $form)
    {
        $funsType = $this->funsType->get($id);
        $funsType->addCharacteristic(
            Characteristic::create(
                $form->name,
                $form->type_variable,
                $form->required,
                $form->default,
                $form->variants,
                $form->sort
            )
        );
        $this->funsType->save($funsType);
    }

    public function updateCharacteristic(int $type_fun_id, int $id, CharacteristicForm $form)
    {
        $funsType = $this->funsType->get($type_fun_id);
        $funsType->updateCharacteristic(
            $id,
            $form->name,
            $form->type_variable,
            $form->required,
            $form->default,
            $form->variants,
            $form->sort
        );
        $this->funsType->save($funsType);
    }

    public function removeCharacteristic(int $type_fun_id, int $id)
    {
        $funsType = $this->funsType->get($type_fun_id);
        $funsType->removeCharacteristic($id);
        $this->funsType->save($funsType);
    }

}