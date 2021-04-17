<?php


namespace booking\repositories\shops;


use booking\entities\shops\products\AdProduct;
use booking\entities\shops\products\BaseProduct;
use booking\entities\shops\products\Product;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class ProductRepository
{
    public function get($id): Product
    {
        if (!$product = Product::findOne($id)) {
            throw new \DomainException('Продукт не найден');
        }
        return $product;
    }

    public function save(BaseProduct $product): void
    {
        if (!$product->save()) {
            throw new \DomainException('Продукт не сохранен');
        }
    }

    public function remove(BaseProduct $product)
    {
        if (!$product->delete()) {
            throw new \DomainException('Ошибка удаления Продукта');
        }
    }

    public function getAd($id): AdProduct
    {
        if (!$product = AdProduct::findOne($id)) {
            throw new \DomainException('Продукт не найден');
        }
        return $product;
    }


    public function existsByCategory($id)
    {
        //TODO переделать под объединение
        return Product::find()->andWhere(['category_id' => $id])->exists();
    }


    public function getAll(): DataProviderInterface
    {
        $query = Product::find()->active();
        $query1 = AdProduct::find()->active();
        $query->union($query1);

        return $this->getProvider($query);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => ['id' => SORT_DESC],
                    /*'attributes' => [
                        'id' => [
                            'asc' => ['id' => SORT_ASC], 'desc' => ['id' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['name' => SORT_ASC], 'desc' => ['name' => SORT_DESC],
                        ],
                        'price' => [
                            'asc' => ['cost' => SORT_ASC], 'desc' => ['cost' => SORT_DESC],
                        ],
                        'rating' => [
                            'asc' => ['rating' => SORT_ASC], 'desc' => ['rating' => SORT_DESC],
                        ],

                    ],*/
                ],
                'pagination' => [
                    'defaultPageSize' => 15,
                    'pageSizeLimit' => [15, 100],
                ],
            ]
        );
    }
}