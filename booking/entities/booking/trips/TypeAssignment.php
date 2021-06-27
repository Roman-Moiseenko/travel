<?php


namespace booking\entities\booking\trips;


use yii\db\ActiveRecord;

/**
 * Class AssignExtra
 * @package booking\entities\booking\trips
 * @property integer $type_id
 * @property int $trip_id [int]
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
        return '{{%booking_trips_type_assign}}';
    }
}