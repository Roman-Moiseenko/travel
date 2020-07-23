<?php


namespace booking\entities\booking\stays\rules;


class Children
{

    public $on;
    public $agelimitfree;

    public function __construct($on = false, $agelimitfree = 16)
    {
        $this->on = $on;
        $this->agelimitfree = $agelimitfree;
    }
}