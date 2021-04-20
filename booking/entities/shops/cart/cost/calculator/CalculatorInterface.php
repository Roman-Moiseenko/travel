<?php


namespace booking\entities\shops\cart\cost\calculator;


use booking\entities\shops\cart\cost\Cost;

interface CalculatorInterface
{
    public function getCost(array $items): Cost;

}