<?php


namespace booking\entities\booking;


class BookingAddress
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