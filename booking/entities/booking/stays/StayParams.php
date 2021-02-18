<?php


namespace booking\entities\booking\stays;


class StayParams
{
    //public $stars;
    public $count_bath; //Кол-во ванных
    public $count_kitchen; //Кол-во кухонь
    public $count_floor; //Колво этажей в доме
    public $square; //Площадь жилья

    public function __construct($square = 1, $count_bath = 1, $count_kitchen = 1, $count_floor = 1)
    {
        $this->square = $square;
        $this->count_bath = $count_bath;
        $this->count_kitchen = $count_kitchen;
        $this->count_floor = $count_floor;
    }

}