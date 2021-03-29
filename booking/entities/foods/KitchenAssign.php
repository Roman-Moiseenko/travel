<?php


namespace booking\entities\foods;


use yii\db\ActiveRecord;

/**
 * Class AssignKitchen
 * @package booking\entities\foods
 * @property integer $food_id
 * @property integer $kitchen_id
 */
class KitchenAssign extends ActiveRecord
{
    public static function create($kitchen_id): self
    {
        $assign = new static();
        $assign->kitchen_id = $kitchen_id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->kitchen_id == $id;
    }

    public static function tableName()
    {
        return '{{%foods_kitchen_assign}}';
    }
}