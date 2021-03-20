<?php


namespace booking\entities\booking\funs;


use booking\entities\booking\CalendarInterface;
use booking\entities\booking\tours\Cost;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class CostCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $fun_id
 * @property integer $fun_at
 * @property integer $time_at
 * @property integer $tickets
 * @property Cost $cost
 * @property Fun $fun
 * @property BookingFunOnDay[] $bookingOnDays
 * @property BookingFun[] $bookings
 * @property SellingFun[] $selling
 * @property int $cost_adult [int]
 * @property int $cost_child [int]
 * @property int $cost_preference [int]
 */
class CostCalendar extends ActiveRecord  implements CalendarInterface
{
   // use ActiveRecordItemTrait;
    public $cost;

    public static function create($fun_at, $time_at, Cost $cost, $tickets): self
    {
        $calendar = new static();
        $calendar->fun_at = $fun_at;
        $calendar->time_at = $time_at;
        $calendar->tickets = $tickets;
        $calendar->cost = $cost;
        return $calendar;
    }

    public static function tableName()
    {
        return '{{%booking_funs_calendar_cost}}';
    }

    public function afterFind(): void
    {
        $this->cost = new Cost(
            $this->getAttribute('cost_adult'),
            $this->getAttribute('cost_child'),
            $this->getAttribute('cost_preference'),
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('cost_adult', $this->cost->adult);
        $this->setAttribute('cost_child', $this->cost->child);
        $this->setAttribute('cost_preference', $this->cost->preference);

        return parent::beforeSave($insert);
    }

    public function isFor($id)
    {
        return $this->id == $id;
    }

    public function isEmpty()
    {
        $bookings = BookingFun::find()->andWhere(['calendar_id' => $this->id])->count();
        return $bookings == 0;
    }

    public function getFun(): ActiveQuery
    {
        return $this->hasOne(Fun::class, ['id' => 'fun_id']);
    }
/*
    public function getFreeTickets(): int 
    {
        $count = 0;
        $bookings = $this->bookings;
        foreach ($bookings as $booking) {
            $count += $booking->count->adult ?? 0;
            $count += $booking->count->child ?? 0;
            $count += $booking->count->preference ?? 0;
        }
        return $this->tickets - $count;
    }*/

    public function getBookingOnDays(): ActiveQuery
    {
        return $this->hasMany(BookingFunOnDay::class, ['calendar_id' => 'id']);
    }

    public function getBookings(): ActiveQuery
    {
        return $this->hasMany(BookingFun::class, ['id' => 'booking_id'])
            ->via('bookingOnDays')
            ->andWhere(['<>', 'booking_funs_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL])
            ->andWhere(['<>', 'booking_funs_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL_PAY]);
    }

    public function getSelling(): ActiveQuery
    {
        return $this->hasMany(SellingFun::class, ['calendar_id' => 'id']);
    }

    public function free(): int
    {
        $count = 0;
        $bookings = $this->bookings;
        foreach ($this->selling as $sale) {
            $count += $sale->count;
        }
        foreach ($bookings as $booking) {
            $count += $booking->count->adult ?? 0;
            $count += $booking->count->child ?? 0;
            $count += $booking->count->preference ?? 0;
        }
        return $this->tickets - $count;
    }

    public function isBooking()
    {
        return count(BookingFun::find()->alias('f')
                ->joinWith('calendars c')
                ->andWhere(['c.id' => $this->id])->all()) > 0;
    }
}