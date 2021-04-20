<?php


namespace booking\entities\shops\cart\cost\calculator;


use booking\entities\shops\cart\cost\calculator\CalculatorInterface;
use booking\entities\shops\cart\cost\Cost;
use booking\entities\shops\cart\cost\Discount;

class DynamicCost implements CalculatorInterface
{

    /**
     * @var CalculatorInterface
     */
    private $next;

    public function __construct(CalculatorInterface $next)
    {
        $this->next = $next;
    }

    public function getCost(array $items): Cost
    {
       /* $discounts = DiscountEntity::find()->active()->all();
        $cost = $this->next->getCoast($items);
        //Только действующие скидки
        $disc = [];
        foreach ($discounts as $discount) {
            if ($discount->isEnabled($cost)) {
                $disc[] = $discount;
            }
        }
        $maxDiscount = $this->getMaxDiscount($disc);
        if ($maxDiscount)
            return $cost->withDiscount(new Discount($maxDiscount->percent, $maxDiscount->name));
        return $cost;*/

    }

  /*  private function getMaxDiscount(array $discounts):? DiscountEntity
    {
        //  Находим максимальную
        $max = 0; $n = 0;
        /* @var $item Discount */
      /*  foreach ($discounts as $i => $item)
        {
            if ($item->percent > $max) {
                $max = $item->percent;
                $n = $i;
            }
        }
        if ($max == 0) return null;
        return $discounts[$n];
    }*/
}