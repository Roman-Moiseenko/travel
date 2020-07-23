<?php


namespace booking\entities\booking\stays\rules;


class Beds
{
    const COUNT_MAX = 4;
    public $on;
    public $count;
    public $upto2_on;
    public $upto2_cost;
    public $child_on;
    public $child_agelimit;
    public $child_cost;
    public $adult_on;
    public $adult_cost;

    public function __construct(
        $on = false, $count = 1,
        $upto2_on = false, $upto2_cost = 0,
        $child_on = false, $child_agelimit = 16, $child_cost = 0,
        $adult_on = false, $adult_cost = 0)
    {
        $this->on = $on;
        $this->count = $count;
        $this->upto2_on = $upto2_on;
        $this->upto2_cost = $upto2_cost;
        $this->child_on = $child_on;
        $this->child_agelimit = $child_agelimit;
        $this->child_cost = $child_cost;
        $this->adult_on = $adult_on;
        $this->adult_cost = $adult_cost;
    }
}