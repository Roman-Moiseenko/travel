<?php


namespace booking\services\office\guides;


use booking\entities\booking\Meals;
use booking\forms\office\guides\MealTypeForm;
use booking\repositories\booking\trips\MealRepository;

class TypeMealService
{
    private $types;

    public function __construct(MealRepository $types)
    {
        $this->types = $types;
    }

    public function create(MealTypeForm $form): Meals
    {
        $type = Meals::create($form->mark, $form->name);
        $sort = $this->types->getMaxSort();
        $type->setSort($sort + 1);
        $this->types->save($type);
        return $type;
    }

    public function edit($id, MealTypeForm $form): void
    {
        $type = $this->types->get($id);
        $type->edit($form->mark, $form->name);
        $this->types->save($type);
    }
    public function moveUp($id)
    {
        $types = $this->types->getAll();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != 0) {
                $t1 = $types[$i - 1];
                $t2 = $type;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->types->save($t1);
                $this->types->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $types = $this->types->getAll();
        $maxSort = $this->types->getMaxSort();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != count($types) - 1) {
                $t1 = $type;
                $t2 = $types[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->types->save($t1);
                $this->types->save($t2);
                return;
            }
        }
    }
    public function remove($id): void
    {
        $type = $this->types->get($id);
        $this->types->remove($type);
    }
}