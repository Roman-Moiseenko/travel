<?php


namespace booking\entities\booking\cars;


use booking\entities\booking\CalendarInterface;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class CostCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $car_id
 * @property integer $car_at
 * @property integer $count
 * @property integer $status
 * @property integer $cost
 * @property Car $car
 * @property BookingCarOnDay[] $bookingOnDays
 * @property BookingCar[] $bookings
 * @property SellingCar[] $selling
 */
class CostCalendar extends ActiveRecord  implements CalendarInterface
{

    public static function create($car_at, $cost, $count): self
    {
        $calendar = new static();
        $calendar->car_at = $car_at;
        $calendar->count = $count;
        $calendar->cost = $cost;
        $calendar->status = Car::CAR_EMPTY;
        return $calendar;
    }

    public static function tableName()
    {
        return '{{%booking_cars_calendar_cost}}';
    }

    public function isFor($id)
    {
        return $this->id == $id;
    }

    public function isEmpty()
    {
        $onDays = BookingCarOnDay::find()->andWhere(['calendar_id' => $this->id])->count();
        return $onDays == 0;
    }

    public function getCar(): ActiveQuery
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
    }

    public function isBegin(): bool
    {
        foreach ($this->bookings as $booking) {
            if ($this->car_at == $booking->begin_at) return true;
        }
        return false;
    }

    public function getFreeCount(): int
    {
        $count = 0;
        $bookings = $this->bookings;

        foreach ($bookings as $booking) {
            $count += $booking->count;
        }
        return $this->count - $count;
    }

    public function getBookingOnDays(): ActiveQuery
    {
        return $this->hasMany(BookingCarOnDay::class, ['calendar_id' => 'id']);
    }

    public function getBookings(): ActiveQuery
    {
        return $this->hasMany(BookingCar::class, ['id' => 'booking_id'])
            ->via('bookingOnDays')
            ->andWhere(['<>', 'booking_cars_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL])
            ->andWhere(['<>', 'booking_cars_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL_PAY]);
        //BookingCarOnDay::tableName(), ['calendar_id' => 'id']
    }

    public function getSelling(): ActiveQuery
    {
        return $this->hasMany(SellingCar::class, ['calendar_id' => 'id']);
    }

    public function free(): int
    {
        $count = 0;
        $bookings = $this->bookings;
        foreach ($this->selling as $sale) {
            $count += $sale->count;
        }
        foreach ($bookings as $booking) {
            $count += $booking->count;
        }
        return $this->count - $count;
    }
}