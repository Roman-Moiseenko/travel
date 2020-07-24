<?php


namespace booking\entities\booking\stays\rules;


class AgeLimit
{
    public $on;
    public $ageMin;
    public $ageMax;

    public function __construct($on = false, $ageMin = null, $ageMax = null)
    {
        $this->on = $on;
        $this->ageMin = $ageMin;
        $this->ageMax = $ageMax;
    }
}