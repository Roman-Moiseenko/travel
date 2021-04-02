<?php


namespace booking\entities\shops\products;


use yii\db\ActiveRecord;

class Category extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%shops_product_category}}';
    }
}