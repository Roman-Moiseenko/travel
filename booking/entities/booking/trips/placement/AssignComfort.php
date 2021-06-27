<?php


namespace booking\entities\booking\trips\placement;


use booking\entities\booking\stays\comfort\Comfort;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class AssignComfort
 * @package booking\entities\booking\trips\placement
 * @property integer $placement_id
 * @property integer $comfort_id
 * @property Comfort $comfort
 */
class AssignComfort extends ActiveRecord
{
    public static function create($comfort_id): self
    {
        $assign = new static();
        $assign->comfort_id = $comfort_id;
        return $assign;
    }

    public static function tableName()
    {
        return '{{%booking_trips_placement_comfort_assign}}';
    }

    public function getComfort(): ActiveQuery
    {
        return $this->hasOne(Comfort::class, ['id' => 'comfort_id'])->orderBy(['category_id' => SORT_ASC, 'sort' => SORT_ASC]);
    }

    public function isFor($id)
    {
        return $this->comfort_id == $id;
    }
}