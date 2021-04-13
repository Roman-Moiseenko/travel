<?php


namespace booking\entities\shops;


use yii\db\ActiveRecord;

/**
 * Class BaseWarehouse
 * @package booking\entities\shops
 * @property integer $id
 * @property integer $product_id
 * @property integer $quantity
 * @property integer $cost
 * @property integer $discovery
 */

abstract class BaseWarehouse extends ActiveRecord
{

    public static function create(): self
    {

    }
}