<?php


namespace booking\entities\booking\stays;


class StaysAddress
{
    public $town;
    public $street;
    public $house;

    public function __construct($town, $street, $house)
    {
        $this->town = $town;
        $this->street = $street;
        $this->house = $house;
    }
}