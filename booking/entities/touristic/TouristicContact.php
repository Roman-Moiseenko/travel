<?php


namespace booking\entities\touristic;


class TouristicContact
{
    public $phone;
    public $url;
    public $email;

    public function __construct($phone, $url, $email)
    {
        $this->phone = $phone;
        $this->url = $url;
        $this->email = $email;
    }
}