<?php


namespace booking\entities\booking;


class BookingAddress
{
    public $town;
    public $street;
    public $house;

    public $latitude;
    public $longitude;

    public function __construct($town, $street, $house, $latitude, $longitude)
    {
        $this->town = $town;
        $this->street = $street;
        $this->house = $house;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}