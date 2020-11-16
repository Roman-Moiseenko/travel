<?php


namespace booking\entities\booking\cars;


use booking\entities\booking\AgeLimit;

class CarParams
{
    public $min_rent;
    public $delivery;
    public $age;
    public $license;
    public $experience;
    //public $onlyDriver; // true - только с водителем

    public function __construct(AgeLimit $age = null, $min_rent = 1, $delivery = false,  $license = 0, $experience = 0)
    {
        $this->min_rent = $min_rent;
        $this->delivery = $delivery;
        $this->age = $age ?? new AgeLimit();
        $this->license = $license;
        $this->experience = $experience;
    }
}