<?php


namespace booking\entities\booking\funs;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class SellingCar
 * @package booking\entities\booking\cars
 * @property int $id
 * @property int $calendar_id
 * @property int $count
 * @property int $created_at
 * @property CostCalendar $calendar
 */
class SellingFun extends ActiveRecord
{

    public static function create($calendar_id, $count): self
    {
        $selling = new static();
        $selling->calendar_id = $calendar_id;
        $selling->count = $count;
        $selling->created_at = time();
        return $selling;
    }

    public static function tableName()
    {
        return '{{%selling_fun}}';
    }

    public function getCalendar(): ActiveQuery
    {
        return $this->hasOne(CostCalendar::class, ['id' => 'calendar_id']);
    }
}