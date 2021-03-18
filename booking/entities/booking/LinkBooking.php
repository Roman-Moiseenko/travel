<?php


namespace booking\entities\booking;


class LinkBooking
{

    public $admin;
    public $booking;
    public $frontend;
    public $pay;
    public $cancelpay;
    public $entities;
    public $office;

    public function __construct($admin, $booking, $frontend, $pay, $cancelpay, $entities, $office)
    {

        $this->admin = $admin;
        $this->booking = $booking;
        $this->frontend = $frontend;
        $this->pay = $pay;
        $this->cancelpay = $cancelpay;
        $this->entities = $entities;
        $this->office = $office;
    }
}