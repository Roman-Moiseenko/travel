<?php


namespace booking\entities\booking\trips;


class CostParams
{
    public $params;
    public $cost;

    public function __construct($params, $cost)
    {
        $this->params = $params;
        $this->cost = $cost;
    }
}