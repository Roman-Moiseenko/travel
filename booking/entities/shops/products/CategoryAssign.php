<?php


namespace booking\entities\shops\products;


use yii\db\ActiveRecord;

class CategoryAssign extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%shops_product_category_assign}}';
    }
}