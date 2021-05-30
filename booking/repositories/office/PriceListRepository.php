<?php


namespace booking\repositories\office;


use booking\entities\office\PriceList;
use booking\entities\shops\AdShop;
use booking\entities\shops\products\AdProduct;
use booking\entities\shops\Shop;

class PriceListRepository
{
    public function get($id): PriceList
    {
        if (!$price = PriceList::findOne($id)) {
            throw new \DomainException('Прайс-лист не найден.');
        }
        return $price;
    }

    public function save(PriceList $price): void
    {
        if (!$price->save()) {
            throw new \DomainException('Ошибка сохранения Прайс-листа.');
        }
    }
    public function remove(PriceList $price): void
    {
        if (!$price->delete()) {
            throw new \DomainException('Ошибка удаления Прайс-листа.');
        }
    }

    public function getPrice(string $key): float
    {
        //if ($key == Shop::class) return 1.0;
        //TODO Протестировать !!!!
        if (!$price = PriceList::findOne(['key' => $key])) {
            throw new \DomainException('Прайс-лист не найден.');
        }
        return $price->amount;
    }
}