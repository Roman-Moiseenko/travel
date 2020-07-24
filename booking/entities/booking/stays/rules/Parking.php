<?php


namespace booking\entities\booking\stays\rules;


class Parking
{
    public $on;
    public $free;
    public $private;
    public $inside;
    public $reserve;
    public $cost;

    public function __construct($on = false, $free = null, $private = null, $inside = null, $reserve = null, $cost = null)
    {
        $this->on = $on;
        $this->free = $free;
        $this->private = $private;
        $this->inside = $inside;
        $this->reserve = $reserve;
        $this->cost = $cost;
    }
}