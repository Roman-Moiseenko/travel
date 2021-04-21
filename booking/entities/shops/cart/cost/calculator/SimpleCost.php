<?php


namespace booking\entities\shops\cart\cost\calculator;


use booking\entities\shops\cart\cost\Cost;

class SimpleCost implements CalculatorInterface
{
    public function getCost(array $items): Cost
    {
        $cost = 0;
        foreach ($items as $item) {
            $cost += $item->getCost();
        }
        return new Cost($cost);
    }
}
