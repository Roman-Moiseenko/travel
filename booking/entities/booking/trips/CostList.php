<?php


namespace booking\entities\booking\trips;


class CostList
{
    public $class;
    public $id;
    public $cost;

    public function __construct($class, $id, $cost)
    {
        $this->class = $class;
        $this->id = $id;
        $this->cost = $cost;
    }
}