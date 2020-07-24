<?php


namespace booking\entities\booking\stays\rules;


class Cards
{
    public $on;
    public $list;

    public function __construct($on = false, array $list = [])
    {
        $this->on = $on;
        $this->list = $list;
    }

}