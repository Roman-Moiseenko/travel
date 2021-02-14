<?php


namespace booking\services\booking\tours;


use booking\entities\booking\tours\CostCalendar;
use booking\entities\booking\tours\stack\Stack;
use booking\forms\booking\tours\StackTourForm;
use booking\repositories\booking\tours\StackTourRepository;

class StackService
{
    /**
     * @var StackTourRepository
     */
    private $stacks;

    public function __construct(StackTourRepository $stacks)
    {
        $this->stacks = $stacks;
    }

    public function create(StackTourForm $form): Stack
    {
        $stack = Stack::create($form->legal_id, $form->count, $form->name);
        /*
        foreach ($form->tours as $tour_id) {
            $stack->addAssign($tour_id);
            }
        */
        $this->stacks->save($stack);
        return $stack;
    }

    public function assignStack($id, array $tour_ids)
    {
        $stack = $this->stacks->get($id);
        $stack->clearAssign();
        $this->stacks->save($stack);
        foreach ($tour_ids as $tour_id) {
            $stack->addAssign($tour_id);
        }
        $this->stacks->save($stack);
    }


    public function edit($id, StackTourForm $form)
    {
        $stack = $this->stacks->get($id);
        $stack->edit($form->legal_id, $form->count, $form->name);
  /*      $stack->clearAssign();
        $this->stacks->save($stack);
        foreach ($form->tours as $tour_id) {
            $stack->addAssign($tour_id);
        }
*/
        $this->stacks->save($stack);
    }

    public function remove($id)
    {
        $stack = $this->stacks->get($id);
        $this->stacks->remove($stack);
    }

    public function setAssign($id, $tour_id, $set)
    {
        $stack = $this->stacks->get($id);
        if ($set) {
            $stack->addAssign($tour_id);
        } else {
            $stack->removeAssign($tour_id);
        }
        $this->stacks->save($stack);
    }


    public function _empty($tour_id, $tour_at): bool
    {
        $stack = $this->stacks->getByTour($tour_id);
        if (!$stack) return true;
        $count = 0;
        foreach ($stack->tours as $tour) {
            if ($tour->id != $tour_id){
                $cost = CostCalendar::find()->andWhere(['tours_id' => $tour->id])->andWhere(['tour_at' => $tour_at])->all();
                $free = true;
                foreach ($cost as $item) {
                    $free = $free && ($item->free() != 0);
                }
                if (!$free) $count++;
                if ($count >= $stack->count) return false;
            }
        }
        return true;
    }
}