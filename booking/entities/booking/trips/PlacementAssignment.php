<?php


namespace booking\entities\booking\trips;


use yii\db\ActiveRecord;

/**
 * Class PlacementAssignment
 * @package booking\entities\booking\trips
 * @property integer $trip_id
 * @property integer $placement_id
 */
class PlacementAssignment extends ActiveRecord
{
    public static function create($placement_id): self
    {
        $assign = new static();
        $assign->placement_id = $placement_id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->placement_id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_trips_placement_assign}}';
    }
}