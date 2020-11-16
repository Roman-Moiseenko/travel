<?php


namespace booking\entities\booking\cars;


use yii\db\ActiveRecord;

/**
 * Class AssignmentCity
 * @package booking\entities\booking\cars
 * @property integer $car_id
 * @property integer $city_id
 */
class AssignmentCity extends ActiveRecord
{
    public static function create($city_id): self
    {
        $assignment = new static();
        $assignment->city_id = $city_id;
        return $assignment;
    }

    public function isFor($id): bool
    {
        return $this->city_id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_cars_city_assignment}}';
    }
}