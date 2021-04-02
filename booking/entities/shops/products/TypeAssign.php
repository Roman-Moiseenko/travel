<?php


namespace booking\entities\shops\products;


use yii\db\ActiveRecord;

/**
 * Class TypeAssign
 * @package booking\entities\shops\products
 * @property integer $shop_id
 * @property integer $type_id
 */
class TypeAssign extends ActiveRecord
{
    public static function create($type_id): self
    {
        $assign = new static();
        $assign->type_id = $type_id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->type_id == $id;
    }

    public static function tableName()
    {
        return '{{%shops_type_assign}}';
    }
}