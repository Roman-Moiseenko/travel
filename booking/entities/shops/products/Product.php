<?php


namespace booking\entities\shops\products;


use yii\db\ActiveRecord;

/**
 * Class Product
 * @package booking\entities\shops\products
 * @property integer $id
 * @property integer $shop_id
 */
class Product extends ActiveRecord
{
    public function getName(): string
    {
        //TODO
    }

    public function getDescription(): string
    {
        //TODO
    }

    public static function tableName()
    {
        return '{{%shops_product}}';
    }
}