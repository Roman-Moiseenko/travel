<?php


namespace booking\entities\booking\stays;


use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class CostCalendar
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property $stay_id
 * @property $stay_at
 * @property integer $status
 * @property integer $cost_base
 * @property integer $guest_base
 * @property integer $cost_add
 *
 * @property Stay $stay
 */
class CostCalendar extends ActiveRecord
{

    public static function create($stay_at, $cost_base, $guest_base, $cost_add): self
    {
        $calendar = new static();
        $calendar->stay_at = $stay_at;
        $calendar->cost_base = $cost_base;
        $calendar->guest_base = $guest_base;
        $calendar->cost_add = $cost_add;

        $calendar->status = Stay::STAY_EMPTY;
        return $calendar;
    }

    public static function tableName()
    {
        return '{{%booking_stays_calendar_cost}}';
    }

    public function isFor($id)
    {
        return $this->id == $id;
    }

    public function isEmpty()
    {
        return true;
        //$onDays = BookingCarOnDay::find()->andWhere(['calendar_id' => $this->id])->count();
        return $onDays == 0;
    }

    public function getStay(): ActiveQuery
    {
        return $this->hasOne(Stay::class, ['id' => 'stay_id']);
    }

    public function isBegin(): bool
    {
        /*foreach ($this->bookings as $booking) {
            if ($this->car_at == $booking->begin_at) return true;
        }*/
        return false;
    }

    public function getFreeCount(): int
    {
        $count = 0;
        return 0;
       /* $bookings = $this->bookings;

        foreach ($bookings as $booking) {
            $count += $booking->count;
        }
        return $this->count - $count; */
    }

    public function getBookingOnDays(): ActiveQuery
    {
        return null;
        //return $this->hasMany(BookingStayOnDay::class, ['calendar_id' => 'id']);
    }

    public function getBookings(): ActiveQuery
    {
        return null;
        /*return $this->hasMany(BookingCar::class, ['id' => 'booking_id'])
            ->via('bookingOnDays')
            ->andWhere(['<>', 'booking_stays_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL])
            ->andWhere(['<>', 'booking_stays_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL_PAY]);
        */
    }

    public function getSelling(): ActiveQuery
    {
        //return $this->hasMany(SellingCar::class, ['calendar_id' => 'id']);
        return null;
    }

    public function free(): int
    {
        $count = 0;
        return 1;
        /*$bookings = $this->bookings;
        foreach ($this->selling as $sale) {
            $count += $sale->count;
        }
        foreach ($bookings as $booking) {
            $count += $booking->count;
        }
        return $this->count - $count; */
    }

    public function isBooking()
    {
        return false;
        /*return count(BookingCar::find()->alias('b')
                ->joinWith('calendars c')
                ->andWhere(['c.id' => $this->id])->all()) > 0; */
    }
}