<?php


namespace booking\entities\booking\tours;


use booking\entities\admin\User;
use booking\entities\booking\BaseBooking;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * Class BookingCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $calendar_id
 * @property integer $user_id
 * @property CostCalendar $calendar
 * @property Cost $count
 * @property integer $status
 * @property integer $created_at

 * @property integer $pincode
 * @property boolean $unload
 *

Выплаты

Выдача билета
 * @property bool $give_out
 * @property integer $give_at
 * @property integer $give_user_id

 * @property Tour $tour
 * @property \booking\entities\check\User $checkUser
 * @property \booking\entities\user\User $user
 * @property int $count_adult [int]
 * @property int $count_child [int]
 * @property int $count_preference [int]
 */

// unload - выгружен или нет для отчета в finance
class BookingTour extends BaseBooking
{
    public $count;

    public static function create(CostCalendar $calendar, Cost $count): self
    {
        $booking = new static();
        $booking->calendar_id = $calendar->id;
        $booking->count = $count;

        $booking->initiate(
            $calendar->tours_id,
            $calendar->tour->legal_id,
            \Yii::$app->user->id,
            $calendar->tour->prepay
        );

        return $booking;
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

    public function getDate(): int
    {
        return $this->calendar->tour_at;
    }

    public function getName(): string
    {
        return $this->tour->getName();
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['tour/common', 'id' => $this->object_id]),
            'booking' => Url::to(['tour/booking/index', 'id' => $this->object_id]),
            'frontend' => Url::to(['cabinet/tour/view', 'id' => $this->id]),
            'pay' => Url::to(['cabinet/pay/tour', 'id' => $this->id]),
            'cancelpay' => Url::to(['cabinet/tour/cancelpay', 'id' => $this->id]),
            'entities' => Url::to(['tour/view', 'id' => $this->object_id]),
            'office' => Url::to(['tours/view', 'id' => $this->object_id]),
        ];
    }

    public function getPhoto(string $photo = 'cabinet_list'): string
    {
        return $this->tour->mainPhoto->getThumbFileUrl('file', $photo);

    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_TOUR;
    }

    public function getAdd(): string
    {
        return $this->calendar->time_at;
    }

    public function getAdmin(): User
    {
        $id = $this->tour->user_id;
        return User::findOne($id);
    }

    public function quantity(): int
    {
        return ($this->count->adult ?? 0) + ($this->count->child ?? 0) + ($this->count->preference ?? 0);
    }

    public function isPaidLocally(): bool //Если предоплата равна нулю, работает через подтверждение
    {
        return $this->tour->prepay == 0;
    }

    public function getDays(): ActiveQuery
    {
        throw new \DomainException('Не используется');
    }

    protected function getFullCostFrom(): float
    {
        return ($this->count->adult * $this->calendar->cost->adult ?? 0) +
            ($this->count->child * $this->calendar->cost->child ?? 0) +
            ($this->count->preference * $this->calendar->cost->preference ?? 0);
    }

    protected function getPrepayFrom(): int
    {
        return $this->tour->prepay;
    }

    public function getTour(): ActiveQuery
    {
        return $this->hasOne(Tour::class, ['id' => 'object_id']);
    }

    public function getCalendars(): ActiveQuery
    {
        throw new \DomainException('Не используется!');
    }
}