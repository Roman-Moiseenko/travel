<?php


namespace booking\entities\booking\cars;


use booking\entities\booking\BaseSelling;
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
class SellingCar extends BaseSelling
{

    public static function tableName()
    {
        return '{{%selling_car}}';
    }

    public function getCalendar(): ActiveQuery
    {
        return $this->hasOne(CostCalendar::class, ['id' => 'calendar_id']);
    }
}