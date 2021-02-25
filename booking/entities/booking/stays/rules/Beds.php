<?php


namespace booking\entities\booking\stays\rules;


class Beds
{
    const COUNT_MAX = 4;
    public $child_on; //доп.кровать детская
    public $child_agelimit; //до какого возраста кровать
    public $child_cost; //0 - бесплатно, > 0 - платно (цена)
    public $child_by_adult; //С какого возраста считается взрослым, или до какого возраста бесплатно
    public $child_count;

    public $adult_on; //доп.кровать
    public $adult_cost; //цена
    public $adult_count; //макс.кол-во

    public function __construct(
        $child_on = false, $child_agelimit = null, $child_cost = null, $child_by_adult = null, $child_count = null,
        $adult_on = false, $adult_cost = null, $adult_count = null
    )
    {
        $this->child_on = $child_on;
        $this->child_agelimit = $child_agelimit;
        $this->child_cost = $child_cost;
        $this->child_by_adult = $child_by_adult;
        $this->child_count = $child_count;

        $this->adult_on = $adult_on;
        $this->adult_cost = $adult_cost;
        $this->adult_count = $adult_count;
    }
}