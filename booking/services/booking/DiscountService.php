<?php


namespace booking\services\booking;


use booking\entities\booking\Discount;

class DiscountService
{
    public function __construct()
    {

    }

    public function get($promo_code, string $entities, int $entities_id)
    {
        /** @var Discount $discount */
        $discount = Discount::find()->andWhere(['promo' => $promo_code])->andWhere(['>', 'count', 0])->one();
        if (!$discount) return null;

        //Проверка на сущности
        switch ($discount->entities) {
            //TODO
        }

    }
}