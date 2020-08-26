<?php


namespace booking\entities\booking\tours;


use booking\entities\booking\BookingItemInterface;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

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
class BookingTour extends ActiveRecord implements BookingItemInterface
{
    public $count;

    public static function create($amount, $calendar_id, Cost $count): self
    {
        $booking = new static();
        $booking->user_id = \Yii::$app->user->id;
        $booking->amount = $amount;
        $booking->calendar_id = $calendar_id;
        $booking->count = $count;
        $booking->status = BookingHelper::BOOKING_STATUS_NEW;
        return $booking;
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
        return $this->status == BookingHelper::BOOKING_STATUS_PAY;
    }

    public function pay()
    {
        $this->status = BookingHelper::BOOKING_STATUS_PAY;
    }

    public function cancel()
    {
        $this->status = BookingHelper::BOOKING_STATUS_CANCEL;
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
        $this->count = new Cost(
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
        return $this->hasOne(CostCalendar::class, ['id' => 'calendar_id']);
    }


    /** ==========> Interface для личного кабинета */
    public function getDate(): int
    {
        return $this->calendar->tour_at;
    }

    public function getName(): string
    {
        return $this->calendar->tour->name;
    }

    public function getLink(): string
    {
        return Url::to(['cabinet/tour/view', 'id' => $this->id]);
    }

    public function getPhoto(): string
    {
        return $this->calendar->tour->mainPhoto->getThumbFileUrl('file', 'cabinet_list');
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_TOUR;
    }

    public function getAdd(): string
    {
        return $this->calendar->time_at;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        if (!$this->save()) {
            throw new \DomainException(Lang::t('Ошибка изменения статуса'));
        }
    }
}