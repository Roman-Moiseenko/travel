<?php


namespace booking\entities\shops\products;


class Product extends BaseProduct
{


    public static function tableName()
    {
        return '{{%shops_product}}';
    }
}