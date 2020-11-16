<?php


namespace booking\entities\booking\cars;


use yii\db\ActiveRecord;

/**
 * Class AssignExtra
 * @package booking\entities\booking\cars
 * @property integer $car_id
 * @property integer $extra_id
 */
class ExtraAssignment extends ActiveRecord
{

    public static function create($extra_id): self
    {
        $assign = new static();
        $assign->extra_id = $extra_id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->extra_id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_cars_extra_assign}}';
    }
}