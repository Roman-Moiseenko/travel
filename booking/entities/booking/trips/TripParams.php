<?php


namespace booking\entities\booking\trips;


class TripParams
{
    public $duration;
    //TODO Авиабилеты
    public $avia_ticket; //1-
    public $transfer; //null - не включен, //0 - предоставляется, > 0 - стоимость услуги
    public $capacity;

    public function __construct($duration, $transfer, $capacity)
    {
        $this->duration = $duration;
        $this->transfer = $transfer;
        $this->capacity = $capacity;
    }

}