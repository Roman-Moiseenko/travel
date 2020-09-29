<?php


namespace booking\services\office\guides;


use booking\entities\booking\tours\Type;
use booking\forms\office\guides\TourTypeForm;
use booking\repositories\booking\tours\TypeRepository;

class TypeService
{
    private $toursType;

    public function __construct(TypeRepository $toursType)
    {
        $this->toursType = $toursType;
    }

    public function create(TourTypeForm $form): Type
    {
        $tourType = Type::create($form->name);
        $sort = $this->toursType->getMaxSort();
        $tourType->setSort($sort + 1);
        $this->toursType->save($tourType);
        return $tourType;
    }

    public function edit($id, TourTypeForm $form): void
    {
        $tourType = $this->toursType->get($id);
        $tourType->edit($form->name);
        $this->toursType->save($tourType);
    }

    public function moveUp($id)
    {
        $types = $this->toursType->getAll();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != 0) {
                $t1 = $types[$i - 1];
                $t2 = $type;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->toursType->save($t1);
                $this->toursType->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $types = $this->toursType->getAll();
        $maxSort = $this->toursType->getMaxSort();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != count($types) - 1) {
                $t1 = $type;
                $t2 = $types[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->toursType->save($t1);
                $this->toursType->save($t2);
                return;
            }
        }
    }

    public function remove($id): void
    {
        $tourType = $this->toursType->get($id);
        $this->toursType->remove($tourType);
    }
}