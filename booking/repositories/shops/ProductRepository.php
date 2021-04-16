<?php


namespace booking\repositories\shops;


use booking\entities\shops\products\AdProduct;
use booking\entities\shops\products\BaseProduct;
use booking\entities\shops\products\Product;

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
}