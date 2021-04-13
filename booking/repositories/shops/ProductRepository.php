<?php


namespace booking\repositories\shops;


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

    public function existsByCategory($id)
    {
        return Product::find()->andWhere(['category_id' => $id])->exists();
    }
}