<?php


namespace booking\entities\booking;


class BookingAddress
{
    public $address;
    public $latitude;
    public $longitude;

    public function __construct($address, $latitude, $longitude)
    {
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}