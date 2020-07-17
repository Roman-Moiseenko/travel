<?php


namespace booking\entities\user;


class UserAddress
{
    public $country;
    public $town;
    public $address;
    public $index;

    public function __construct($country, $town = '', $address = '', $index = '')
    {
        $this->country = $country;
        $this->town = $town;
        $this->address = $address;
        $this->index = $index;
    }
}