<?php


namespace booking\entities\booking\tours;


use booking\entities\booking\BookingAddress;
use booking\entities\booking\stays\rules\AgeLimit;

class TourParams
{
    public $duration;
    public $private;
    public $groupMin;
    public $groupMax;
    public $beginAddress;
    public $endAddress;
    public $agelimit;

    public function __construct(
        $duration, BookingAddress $beginAddress, BookingAddress $endAddress,
        AgeLimit $agelimit, $private = false,
        $groupMin = 0, $groupMax = null)
    {
        $this->duration = $duration;
        $this->beginAddress = $beginAddress;
        $this->endAddress = $endAddress;
        $this->agelimit = $agelimit;
        $this->private = $private;
        $this->groupMin = $groupMin;
        $this->groupMax = $groupMax;
    }
}