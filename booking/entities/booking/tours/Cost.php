<?php


namespace booking\entities\booking\tours;


class Cost
{
    public $adult;
    public $child;
    public $preference;

    public function __construct($adult = null, $child = null, $preference = null)
    {
        $this->adult = $adult;
        $this->child = $child;
        $this->preference = $preference;
    }
    public function count()
    {
        return $this->adult + ($this->child ?? 0) + ($this->preference ?? 0);
    }
}