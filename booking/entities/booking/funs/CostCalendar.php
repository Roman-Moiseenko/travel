<?php


namespace booking\entities\booking\funs;


use booking\entities\booking\BaseCalendar;
use booking\entities\booking\tours\Cost;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;

/**
 * Class CostCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $fun_id
 * @property integer $fun_at
 *
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
class CostCalendar extends BaseCalendar
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

    public function isEmpty(): bool
    {
        $bookings = BookingFun::find()->andWhere(['calendar_id' => $this->id])->count();
        return $bookings == 0;
    }

    public function getFun(): ActiveQuery
    {
        return $this->hasOne(Fun::class, ['id' => 'fun_id']);
    }

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

    public function getAllBookings(): ActiveQuery
    {
        return $this->hasMany(BookingFun::class, ['calendar_id' => 'id']);
    }

    public function isCancelProvider(): bool
    {
        if ($this->fun_at < time()) return false; //уже прошло
        //Добавить условия для отмены, если понадобятся
        return false;
    }

    protected function _count(): int
    {
        return $this->tickets;
    }

    public function getDate_at(): int
    {
        return $this->fun_at;
    }

    public function setDate_at(int $date_at): void
    {
        $this->fun_at = $date_at;
    }

    public function cloneDate(int $date_at): BaseCalendar
    {
        return CostCalendar::create($date_at, $this->time_at, new Cost($this->cost->adult, $this->cost->child, $this->cost->preference), $this->tickets);
    }
}