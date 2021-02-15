<?php


namespace booking\services\office\guides;

use booking\entities\booking\stays\Type;

use booking\forms\office\guides\StayTypeForm;
use booking\repositories\booking\stays\TypeRepository;

class TypeStayService
{
    /**
     * @var TypeRepository
     */
    private $staysType;

    public function __construct(TypeRepository $staysType)
    {
        $this->staysType = $staysType;
    }

    public function create(StayTypeForm $form): Type
    {
        $staysType = Type::create($form->name, $form->slug);
        $sort = $this->staysType->getMaxSort();
        $staysType->setSort($sort + 1);
        $this->staysType->save($staysType);
        return $staysType;
    }

    public function edit($id, StayTypeForm $form): void
    {
        $staysType = $this->staysType->get($id);
        $staysType->edit($form->name, $form->slug);
        $this->staysType->save($staysType);
    }

    public function moveUp($id)
    {
        $types = $this->staysType->getAll();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != 0) {
                $t1 = $types[$i - 1];
                $t2 = $type;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->staysType->save($t1);
                $this->staysType->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $types = $this->staysType->getAll();
        //$maxSort = $this->staysType->getMaxSort();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != count($types) - 1) {
                $t1 = $type;
                $t2 = $types[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->staysType->save($t1);
                $this->staysType->save($t2);
                return;
            }
        }
    }

    public function remove($id): void
    {
        $staysType = $this->staysType->get($id);
        $this->staysType->remove($staysType);
    }
}