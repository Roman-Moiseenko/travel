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

    public function save(Discount $discount): void
    {
        if (!$discount->save()) {
            throw new \RuntimeException('Скидка не сохранена');
        }
    }

    public function remove(Discount $discount)
    {
        if (!$discount->delete()) {
            throw new \RuntimeException('Ошибка удаления скидки');
        }
    }
}