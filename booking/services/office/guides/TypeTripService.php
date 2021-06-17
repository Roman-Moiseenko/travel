<?php


namespace booking\services\office\guides;

use booking\entities\booking\trips\Type;

use booking\forms\office\guides\TripTypeForm;
use booking\repositories\booking\trips\TypeRepository;

class TypeTripService
{


    /**
     * @var TypeRepository
     */
    private $tripsType;

    public function __construct(TypeRepository $tripsType)
    {
        $this->tripsType = $tripsType;
    }

    public function create(TripTypeForm $form): Type
    {
        $tripType = Type::create($form->name, $form->slug);
        $sort = $this->tripsType->getMaxSort();
        $tripType->setSort($sort + 1);
        $this->tripsType->save($tripType);
        return $tripType;
    }

    public function edit($id, TripTypeForm $form): void
    {
        $tripType = $this->tripsType->get($id);
        $tripType->edit($form->name, $form->slug);
        $this->tripsType->save($tripType);
    }

    public function moveUp($id)
    {
        $types = $this->tripsType->getAll();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != 0) {
                $t1 = $types[$i - 1];
                $t2 = $type;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->tripsType->save($t1);
                $this->tripsType->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $types = $this->tripsType->getAll();
        $maxSort = $this->tripsType->getMaxSort();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != count($types) - 1) {
                $t1 = $type;
                $t2 = $types[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->tripsType->save($t1);
                $this->tripsType->save($t2);
                return;
            }
        }
    }

    public function remove($id): void
    {
        $tripType = $this->tripsType->get($id);
        $this->tripsType->remove($tripType);
    }
}