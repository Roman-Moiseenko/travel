<?php


namespace booking\entities\booking\hotels\rooms;


class Capacity
{
    public $adult;
    public $child;

    public function __construct($adult, $child)
    {
        $this->adult = $adult;
        $this->child = $child;
    }

    public function total(): int
    {
        return $this->adult + $this->child;
    }

}