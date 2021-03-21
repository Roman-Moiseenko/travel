<?php


namespace booking\entities\booking\cars;


use booking\entities\booking\BaseCalendar;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;


/**
 * Class CostCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $car_id
 * @property integer $car_at
 *
 * @property integer $count
 * @property integer $cost
 * @property Car $car
 * @property BookingCarOnDay[] $bookingOnDays
 * @property BookingCar[] $bookings
 * @property SellingCar[] $selling
 */
class CostCalendar extends BaseCalendar
{

    public static function create($car_at, $cost, $count): self
    {
        $calendar = new static();
        $calendar->car_at = $car_at;
        $calendar->count = $count;
        $calendar->cost = $cost;
        return $calendar;
    }

    public static function tableName()
    {
        return '{{%booking_cars_calendar_cost}}';
    }

    public function isEmpty():bool
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

    public function isBooking()
    {
        return count(BookingCar::find()->alias('b')
                ->joinWith('calendars c')
                ->andWhere(['c.id' => $this->id])->all()) > 0;
    }

    public function getAllBookings(): ActiveQuery
    {
        return $this->hasMany(BookingCar::class, ['calendar_id' => 'id']);
    }

    public function isCancelProvider(): bool
    {
        if ($this->car_at < time()) return false; //уже прошло
        //Добавить условия для отмены, если понадобятся
        return false;
    }

    protected function _count(): int
    {
        return $this->count;
    }

    public function getDate_at(): int
    {
        return $this->car_at;
    }

    public function setDate_at(int $date_at): void
    {
        $this->car_at = $date_at;
    }

    public function cloneDate(int $date_at): BaseCalendar
    {
        return CostCalendar::create($date_at, $this->cost, $this->count);
    }
}