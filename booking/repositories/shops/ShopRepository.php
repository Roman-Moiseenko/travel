<?php


namespace booking\repositories\shops;


use booking\entities\shops\AdShop;
use booking\entities\shops\BaseShop;
use booking\entities\shops\Shop;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\db\Query;

class ShopRepository
{
    public function get($id): Shop
    {
        if (!$result = Shop::findOne($id)) {
            throw new \DomainException('Магазин не найден');
        }
        return $result;
    }

    public function save(Shop $shop)
    {
        if (!$shop->save()) {
            throw new \DomainException('Магазин не сохранен');
        }
    }


    public function remove(Shop $shop)
    {
        if (!$shop->delete()) {
            throw new \DomainException('Ошибка удаления магазина');
        }
    }

}