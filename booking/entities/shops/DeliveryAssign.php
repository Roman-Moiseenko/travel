<?php


namespace booking\entities\shops;


use yii\db\ActiveRecord;

/**
 * Class DeliveryAssign
 * @package booking\entities\shops
 * @property integer $shop_id
 * @property integer $delivery_company_id
 */
class DeliveryAssign extends ActiveRecord
{
    public static function create($delivery_company_id): self
    {
        $assign = new static();
        $assign->delivery_company_id = $delivery_company_id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->delivery_company_id == $id;
    }

    public static function tableName()
    {
        return '{{%shops_delivery_company_assign}}';
    }
}