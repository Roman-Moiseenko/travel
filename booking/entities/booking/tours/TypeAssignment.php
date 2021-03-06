<?php


namespace booking\entities\booking\tours;


use yii\db\ActiveRecord;

/**
 * Class AssignExtra
 * @package booking\entities\booking\tours
 * @property integer $tours_id
 * @property integer $type_id
 */
class TypeAssignment extends ActiveRecord
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
        return '{{%booking_tours_type_assign}}';
    }
}