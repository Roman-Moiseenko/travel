<?php


namespace booking\entities\booking\cars;


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
class SellingCar extends ActiveRecord
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
        return '{{%selling_car}}';
    }

    public function getCalendar(): ActiveQuery
    {
        return $this->hasOne(CostCalendar::class, ['id' => 'calendar_id']);
    }
}