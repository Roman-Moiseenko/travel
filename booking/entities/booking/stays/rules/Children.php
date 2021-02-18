<?php


namespace booking\entities\booking\stays\rules;


class Children
{

    public $on; //Разрешено с детьми
    public $age_free; //С какого возраста считается взрослым, или до какого возраста бесплатно

    public function __construct($on = false, $age_free = 16)
    {
        $this->on = $on;
        $this->age_free = $age_free;
    }
}