<?php


namespace booking\entities\booking\trips;


use booking\entities\booking\BaseCalendar;
use booking\helpers\BookingHelper;

use yii\db\ActiveQuery;


/**
 * Class CostCalendar
 * @package booking\entities\booking\trips
 * @property integer $id
 * @property $trip_id
 * @property $trip_at
 *
 * @property integer $quantity
 * @property integer $cost
 *
 * @property Trip $trip
 */
class CostCalendar extends BaseCalendar
{

    public static function create($trip_at, $cost, $quantity): self
    {
        $calendar = new static();
        $calendar->trip_at = $trip_at;
        $calendar->cost = $cost;
        $calendar->quantity = $quantity;

        return $calendar;
    }

    public static function tableName()
    {
        return '{{%booking_trips_calendar_cost}}';
    }

    public function isEmpty(): bool
    {
        return true;
        //$onDays = BookingStayOnDay::find()->andWhere(['calendar_id' => $this->id])->count();
        //return $onDays == 0;
    }

    public function getTrip(): ActiveQuery
    {
        return $this->hasOne(Trip::class, ['id' => 'trip_id']);
    }

    public function isBegin(): bool
    {
        foreach ($this->bookings as $booking) {
            if ($this->trip_at == $booking->begin_at) return true;
        }
        return false;
    }
/*
    public function getBookingOnDays(): ActiveQuery
    {
        return $this->hasOne(BookingStayOnDay::class, ['calendar_id' => 'id']);
    }*/

    public function getBookings(): ActiveQuery
    {
        return $this->hasMany(BookingTrip::class, ['id' => 'booking_id'])
            ->via('bookingOnDays')
            ->andWhere(['<>', 'booking_stays_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL])
            ->andWhere(['<>', 'booking_stays_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL_PAY]);
    }

    public function getSelling(): ActiveQuery
    {
        return $this->hasMany(BookingTrip::class, ['calendar_id' => 'id']);
    }

    public function free(): int
    {
        if ($this->bookings) return 0;
        if ($this->selling) return 0;
        return 1;
    }

    public function isBooking()
    {
        return false;
        /*return count(BookingTrip::find()->alias('t')
                ->joinWith('calendars c')
                ->andWhere(['c.id' => $this->id])->all()) > 0; */
    }

    public function getAllBookings(): ActiveQuery
    {
        // TODO: Implement getAllBookings() method.
    }

    public function isCancelProvider(): bool
    {
        // TODO: Implement isCancelProvider() method.
    }

    protected function _count(): int
    {
        return $this->quantity;
    }

    public function getDate_at(): int
    {
        return $this->trip_at;
    }

    public function setDate_at(int $date_at): void
    {
        $this->trip_at = $date_at;
    }

    public function cloneDate(int $date_at): BaseCalendar
    {
        // TODO: Implement cloneDate() method.
    }
}