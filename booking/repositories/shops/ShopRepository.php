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

    public function getAd($id): AdShop
    {
        if (!$result = AdShop::findOne($id)) {
            throw new \DomainException('Магазин не найден');
        }
        return $result;

    }

    public function save(BaseShop $shop)
    {
        if (!$shop->save()) {
            throw new \DomainException('Магазин не сохранен');
        }
    }


    public function remove(BaseShop $shop)
    {
        if (!$shop->delete()) {
            throw new \DomainException('Ошибка удаления магазина');
        }
    }

    public function searchModel(): DataProviderInterface
    {
        $query = \Yii::$app->db->createCommand(
            "SELECT type_id, name, status, public_at, CONCAT('/shop/products/', id) AS url, CONCAT('Онлайн') as type_shop FROM " .
            Shop::tableName() . " WHERE user_id = " . \Yii::$app->user->id . " UNION " .
            "SELECT type_id, name, status, public_at, CONCAT('/shop-ad/products/', id) AS url, CONCAT('Реклама') as type_shop FROM " .
            AdShop::tableName() . " WHERE user_id = " . \Yii::$app->user->id
        )
            ->queryAll();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query,
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $dataProvider;//$this->getProvider($query);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id' => [
                        'asc' => ['public_at' => SORT_ASC], 'desc' => ['public_at' => SORT_DESC],
                    ],
                    'name' => [
                        'asc' => ['name' => SORT_ASC], 'desc' => ['name' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => [
                'defaultPageSize' => 10,
                'pageSizeLimit' => [10, 10],
            ],
        ]);
    }

}