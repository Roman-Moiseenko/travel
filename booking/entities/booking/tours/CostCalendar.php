<?php


namespace booking\entities\booking\tours;


use booking\entities\booking\CalendarInterface;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class CostCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $tours_id
 * @property integer $tour_at
 * @property integer $time_at
 * @property integer $tickets
 * @property integer $status

 * @property Tour $tour
 * @property BookingTour[] $bookings
 * @property BookingTour[] $allBookings
 * @property SellingTour[] $selling

 * @property int $cost_adult [int]
 * @property int $cost_child [int]
 * @property int $cost_preference [int]
 */
class CostCalendar extends ActiveRecord  implements CalendarInterface
{
   // use ActiveRecordItemTrait;
    public $cost;

    public static function create($tour_at, $time_at, Cost $cost, $tickets): self
    {
        $calendar = new static();
        $calendar->tour_at = $tour_at;
        $calendar->time_at = $time_at;
        $calendar->tickets = $tickets;
        $calendar->cost = $cost;
        $calendar->status = Tour::TOUR_EMPTY;
        return $calendar;
    }

    public static function tableName()
    {
        return '{{%booking_tours_calendar_cost}}';
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
        $bookings = BookingTour::find()->andWhere(['calendar_id' => $this->id])->count();
        return $bookings == 0;
    }

    public function getTour(): ActiveQuery
    {
        return $this->hasOne(Tour::class, ['id' => 'tours_id']);
    }

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
    }
    
    public function getBookings(): ActiveQuery
    {
        return $this->hasMany(BookingTour::class, ['calendar_id' => 'id'])
            ->andWhere(['<>', 'booking_tours_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL])
            ->andWhere(['<>', 'booking_tours_calendar_booking.status', BookingHelper::BOOKING_STATUS_CANCEL_PAY]);
    }

    public function getAllBookings(): ActiveQuery
    {
        return $this->hasMany(BookingTour::class, ['calendar_id' => 'id']);
    }

    public function getSelling(): ActiveQuery
    {
        return $this->hasMany(SellingTour::class, ['calendar_id' => 'id']);
    }


    public function free(): int
    {
        /*$count = 0;
        $bookings = $this->bookings;
        foreach ($this->selling as $sale) {
            $count += $sale->count;
        }
        foreach ($bookings as $booking) {
            $count += $booking->count->adult ?? 0;
            $count += $booking->count->child ?? 0;
            $count += $booking->count->preference ?? 0;
        }*/
        return $this->tickets - $this->count();
    }

    private function count(): int
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
        return $count;
    }

    public function isCancelProvider(): bool
    {
        //TODO Проверка, можно ли отменить провайдеру: Добавлять время или нет??? ----
        $tour = $this->tour;
        if ($tour->params->private) return false;
        if ($this->count() == 0) return false;
        if ($tour->params->groupMin > $this->count()) return true;
        return false;
    }
}