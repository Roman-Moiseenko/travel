<?php


namespace booking\repositories\shops;


use booking\entities\shops\products\AdProduct;
use booking\entities\shops\products\Category;
use booking\entities\shops\products\Product;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ProductRepository
{
    public function get($id): Product
    {
        if (!$product = Product::findOne($id)) {
            throw new \DomainException('Продукт не найден');
        }
        return $product;
    }

    public function save(Product $product): void
    {
        if (!$product->save()) {
            throw new \DomainException('Продукт не сохранен');
        }
    }

    public function remove(Product $product)
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
        return Product::find()->andWhere(['category_id' => $id])->exists();
    }

    public function search(array $search): DataProviderInterface
    {
        //TODO ЗАГЛУШКА
        return $this->getAll();
    }

    public function getAll(): DataProviderInterface
    {
        $query = Product::find()->active();


        return $this->getProvider($query);
    }

    public function getAllByCategory(?Category $category)
    {
        $query = Product::find()->active()/*->NotEmpty('p')*/ ->with('mainPhoto', 'category');
        $ids = ArrayHelper::merge([$category->id],
            $category->getLeaves()->select('id')->column(),
            $category->getChildren()->select('id')->column());
        $query->andWhere(['category_id' => $ids]);
        $query->groupBy('id');
        return $this->getProvider($query);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => ['id' => SORT_DESC],
                    'attributes' => [
                        'id' => [
                            'asc' => ['id' => SORT_ASC], 'desc' => ['id' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['name' => SORT_ASC], 'desc' => ['name' => SORT_DESC],
                        ],
                        'cost' => [
                            'asc' => ['cost' => SORT_ASC], 'desc' => ['cost' => SORT_DESC],
                        ],
                        'rating' => [
                            'asc' => ['rating' => SORT_ASC], 'desc' => ['rating' => SORT_DESC],
                        ],

                    ],
                ],
                'pagination' => [
                    'defaultPageSize' => 80,
                    'pageSizeLimit' => [80, 200],
                ],
            ]
        );
    }

    public function getForFrontend($id):? Product
    {
        if (!$product = Product::find()->active()->andWhere(['id' => $id])->one()) {
            throw new NotFoundHttpException('Продукт не найден');
        }
        return $product;
    }

    public function getAllForSitemap()
    {
        return Product::find()->active()->all();
    }
}