<?php


namespace booking\entities\booking\stays\rules;


class Cards
{
    public $on;
    public $json;

    public function __construct($on = false, $json = '{}')
    {
        $this->on = $on;
        $this->json = $json;
    }

}