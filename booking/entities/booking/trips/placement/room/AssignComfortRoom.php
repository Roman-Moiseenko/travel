<?php


namespace booking\entities\booking\trips\placement\room;


use booking\entities\booking\stays\comfort_room\ComfortRoom;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class AssignComfortRoom
 * @package booking\entities\booking\trips\placement\room
 * @property integer $room_id
 * @property integer $comfort_id
 * @property ComfortRoom $comfort
 */
class AssignComfortRoom extends ActiveRecord
{
    public static function create($comfort_id): self
    {
        $assign = new static();
        $assign->comfort_id = $comfort_id;
        return $assign;
    }

    public function isFor($id)
    {
        return $this->comfort_id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_trips_placement_room_comfort_assign}}';
    }

    public function getComfort(): ActiveQuery
    {
        return $this->hasOne(ComfortRoom::class, ['id' => 'comfort_id'])->orderBy(['category_id' => SORT_ASC, 'sort' => SORT_ASC]);
    }
}