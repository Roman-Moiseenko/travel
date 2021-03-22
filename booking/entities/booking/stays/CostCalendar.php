<?php


namespace booking\entities\booking\stays;


use booking\entities\booking\BaseCalendar;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class CostCalendar
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property $stay_id
 * @property $stay_at
 *
 * @property integer $cost_base
 * @property integer $guest_base
 * @property integer $cost_add
 *
 * @property Stay $stay
 */
class CostCalendar extends BaseCalendar
{

    public static function create($stay_at, $cost_base, $guest_base, $cost_add): self
    {
        $calendar = new static();
        $calendar->stay_at = $stay_at;
        $calendar->cost_base = $cost_base;
        $calendar->guest_base = $guest_base;
        $calendar->cost_add = $cost_add;
        return $calendar;
    }

    public static function tableName()
    {
        return '{{%booking_stays_calendar_cost}}';
    }

    public function isEmpty(): bool
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

    public function getBookingOnDays(): ActiveQuery
    {
        return $this->hasOne(BookingStayOnDay::class, ['calendar_id' => 'id']);
    }

    public function getBookings(): ActiveQuery
    {
        return $this->hasMany(BookingStay::class, ['id' => 'booking_id'])
            ->via('bookingOnDays')
            ->andWhere(['<>', 'booking_stays_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL])
            ->andWhere(['<>', 'booking_stays_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL_PAY]);

    }

    public function getSelling(): ActiveQuery
    {
        return $this->hasMany(SellingStay::class, ['calendar_id' => 'id']);

    }

    public function free(): int
    {
       /* scr::_p($this->bookings);
        scr::_p($this->selling);
*/
        if ($this->bookings) return 0;
        if ($this->selling) return 0;
        return 1;
    }

    public function isBooking()
    {
        return false;
        /*return count(BookingCar::find()->alias('b')
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
        // TODO: Implement _count() method.
    }

    public function getDate_at(): int
    {
        return $this->stay_at;
    }

    public function setDate_at(int $date_at): void
    {
        $this->stay_at = $date_at;
    }

    public function cloneDate(int $date_at): BaseCalendar
    {
        // TODO: Implement cloneDate() method.
    }
}