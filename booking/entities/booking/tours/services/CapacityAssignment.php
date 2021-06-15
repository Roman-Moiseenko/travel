<?php


namespace booking\entities\booking\tours\services;


use yii\db\ActiveRecord;

/**
 * Class CapacityAssignment
 * @package booking\entities\booking\tours\services
 * @property int $tour_id [int]
 * @property int $capacity_id [int]
 */
class CapacityAssignment extends ActiveRecord
{
    public static function create($capacity_id): self
    {
        $assign = new static();
        $assign->capacity_id = $capacity_id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->capacity_id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_tours_capacity_assign}}';
    }
}