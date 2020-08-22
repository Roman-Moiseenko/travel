<?php


namespace booking\entities\booking\tours;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class BookingCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $calendar_id
 * @property integer $user_id
 * @property CostCalendar $calendar
 * @property integer $amount
 * @property Cost $count
 * @property integer $status
 */
class BookingTour extends ActiveRecord
{
    const BOOKING_NEW = 1;
    const BOOKING_PAY = 2;
    const BOOKING_CANCEL = 3;
    //const BOOKING_NEW = 1;
    public $count;

    public static function create($amount, $calendar_id, Cost $count): self
    {
        $calendar = new static();
        $calendar->amount = $amount;
        $calendar->calendar_id = $calendar_id;
        $calendar->count = $count;
        $calendar->status = self::BOOKING_NEW;
        return $calendar;
    }

    public function edit($amount, Cost $count): void
    {
        $this->amount = $amount;
        $this->count = $count;
    }

    public function isFor($id): bool
    {
        return $this->id === $id;
    }

    public function isPay(): bool
    {
        return $this->status == self::BOOKING_PAY;
    }

    public function pay()
    {
        $this->status = self::BOOKING_PAY;
    }

    public function cancel()
    {
        $this->status = self::BOOKING_CANCEL;
    }

    public function countTickets(): int
    {
        return ($this->count->adult ?? 0) + ($this->count->child ?? 0) + ($this->count->preference ?? 0);
    }
    public static function tableName()
    {
        return '{{%booking_tours_calendar_booking}}';
    }
    public function afterFind(): void
    {
        $this->cost = new Cost(
            $this->getAttribute('count_adult'),
            $this->getAttribute('count_child'),
            $this->getAttribute('count_preference'),
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('count_adult', $this->count->adult);
        $this->setAttribute('count_child', $this->count->child);
        $this->setAttribute('count_preference', $this->count->preference);

        return parent::beforeSave($insert);
    }
    public function getCalendar(): ActiveQuery
    {
        return $this->hasOne(CostCalendar::class, ['id' => 'calendar']);
    }
}