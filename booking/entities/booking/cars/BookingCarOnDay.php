<?php


namespace booking\entities\booking\cars;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * @property integer $booking_id
 * @property integer $calendar_id
 * @property CostCalendar $calendar
 */

class BookingCarOnDay extends ActiveRecord
{
    public static function create($calendar_id): self
    {
        $bookingOnDay = new static();
        $bookingOnDay->calendar_id = $calendar_id;
        return $bookingOnDay;
    }

    public static function tableName()
    {
        return '{{%booking_cars_calendar_booking_on_day}}';
    }

    public function getCalendar(): ActiveQuery
    {
        return $this->hasOne(CostCalendar::class, ['id' => 'calendar_id']);
    }
}