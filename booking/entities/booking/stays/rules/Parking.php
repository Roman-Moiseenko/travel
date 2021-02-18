<?php


namespace booking\entities\booking\stays\rules;


class Parking
{
    public $on; //да, нет
    public $free; //платно, бесплатно
    public $private; //выделаная или на общем месте
    public $inside; //крытая, некрытая
    public $reserve; ////возможность забронировать
    public $cost; //цена

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