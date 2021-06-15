<?php


namespace booking\entities\booking\tours\services;


class BookingServices
{
    public $time_cost;
    public $time_count;
    public $capacity_count;
    public $capacity_percent;
    public $transfer_path;
    public $transfer_cost;

    public function __construct($time_cost, $time_count, $capacity_count,$capacity_percent, $transfer_path, $transfer_cost)
    {
        $this->time_cost = $time_cost;
        $this->time_count = $time_count;
        $this->capacity_count = $capacity_count;
        $this->capacity_percent = $capacity_percent;
        $this->transfer_path = $transfer_path;
        $this->transfer_cost = $transfer_cost;
    }
}