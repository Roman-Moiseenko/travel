<?php


namespace booking\entities\booking\stays;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class BookingStayOnDay
 * @package booking\entities\booking\stays
 * @property integer $booking_id
 * @property integer $calendar_id
 * __property integer $guest_add
 * @property CostCalendar $calendar
 */

class BookingStayOnDay extends ActiveRecord
{
    public static function create($calendar_id): self
    {
        $bookingOnDay = new static();
        $bookingOnDay->calendar_id = $calendar_id;
        return $bookingOnDay;
    }

    public static function tableName()
    {
        return '{{%booking_stays_calendar_booking_on_day}}';
    }

    public function getCalendar(): ActiveQuery
    {
        return $this->hasOne(CostCalendar::class, ['id' => 'calendar_id']);
    }
}