<?php


namespace booking\entities\booking\cars;


use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\Discount;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

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