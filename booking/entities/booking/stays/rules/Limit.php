<?php


namespace booking\entities\booking\stays\rules;


class Limit
{
    public $smoking;
    public $animals; //нет, бесплатно, платно
    public $children; //
    public $children_allow; //С какого возраста разрешено детям

    public function __construct($smoking = null, $animals = null, $children = null, $children_allow = 0)
    {
        $this->smoking = $smoking;
        $this->animals = $animals;
        $this->children = $children;
        $this->children_allow = $children_allow;
    }

    public function isAnimals(): bool
    {
        return $this->animals != Rules::STATUS_NOT;
    }
}