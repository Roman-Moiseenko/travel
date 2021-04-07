<?php


namespace booking\services\shops;


use booking\entities\shops\products\BaseProduct;
use booking\entities\shops\products\Product;
use booking\forms\shops\ProductForm;

class ProductService
{

    public function create(ProductForm $form): BaseProduct
    {
        $product = Product::create(
            $form->name,

        );

        return $product;
    }
}