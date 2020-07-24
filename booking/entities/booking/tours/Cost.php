<?php


namespace booking\entities\booking\tours;


class Cost
{
    public $adult;
    public $child;
    public $preference;

    public function __construct($adult, $child = null, $preference = null)
    {
        $this->adult = $adult;
        $this->child = $child;
        $this->preference = $preference;
    }
}