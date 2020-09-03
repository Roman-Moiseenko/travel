<?php


namespace booking\repositories\booking;


use booking\entities\booking\Discount;

class DiscountRepository
{
    public function get($id): Discount
    {
        if (!$result = Discount::findOne($id)) {
            throw new \DomainException('Скидка на найдена');
        }
        return $result;
    }
}