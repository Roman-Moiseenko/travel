<?php


namespace booking\entities\booking\stays\rules;


class Limit
{
    public $smoking;
    public $animals;
    public $children;

    public function __construct($smoking = false, $animals = false, $children = false)
    {
        $this->smoking = $smoking;
        $this->animals = $animals;
        $this->children = $children;
    }
}