<?php


namespace booking\entities\realtor\land;


class Point
{
    public $latitude;
    public $longitude;

    public static function create($latitude, $longitude): self
    {
        $point = new static();
        $point->latitude = $latitude;
        $point->longitude = $longitude;
        return $point;
    }
}