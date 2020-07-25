<?php


namespace booking\entities\booking\tours;


use yii\db\ActiveRecord;

/**
 * Class BookingCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $tours_id
 * @property integer $user_id
 * @property integer $tour_at
 * @property integer $amount
 * @property Cost $count
 */
class BookingCalendar extends ActiveRecord
{
    public $count;

    public static function create($user_id, $tour_at, Cost $count): self
    {
        $calendar = new static();
        $calendar->user_id = $user_id;
        $calendar->tour_at = $tour_at;
        $calendar->count = $count;
        return $calendar;
    }

    public function edit($tour_at, Cost $count): void
    {
        $this->tour_at = $tour_at;
        $this->count = $count;
    }

    public function pay($amount): void
    {
        $this->amount = $amount;
    }

    public function isPay(): bool
    {
        return $this->amount == null ? false : true;
    }
    public static function tableName()
    {
        return '{{%booking_tours_calendar_booking}}';
    }
}