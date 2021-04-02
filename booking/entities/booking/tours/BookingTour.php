<?php


namespace booking\entities\booking\tours;


use booking\entities\admin\User;
use booking\entities\booking\BaseBooking;
use booking\entities\booking\LinkBooking;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * Class BookingCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $calendar_id
 * @property integer $user_id
 * @property CostCalendar $calendar
 * @property integer $status
 * @property integer $created_at
 * @property integer $pincode
 * @property boolean $unload
 *
* Выдача билета
 * @property bool $give_out
 * @property integer $give_at
 * @property integer $give_user_id
 * @property Tour $tour
 * @property \booking\entities\check\User $checkUser
 * @property \booking\entities\user\User $user
 * @property int $count_adult [int]
 * @property int $count_child [int]
 * @property int $count_preference [int]
 * @property string $payment_id [varchar(255)]
 * @property float $payment_provider [float]
 * @property float $payment_merchant [float]
 * @property float $payment_deduction [float]
 * @property int $payment_date [int]
 * @property int $payment_full_cost [int]
 * @property int $payment_prepay [int]
 * @property int $payment_percent [int]
 * @property string $payment_confirmation [varchar(255)]
 */

// unload - выгружен или нет для отчета в finance
class BookingTour extends BaseBooking
{
    /** @var $count Cost */
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

    public function getLinks(): LinkBooking
    {
        $link = new LinkBooking(
            Url::to(['tour/common', 'id' => $this->object_id]),
            Url::to(['tour/booking/index', 'id' => $this->object_id]),
            Url::to(['cabinet/tour/view', 'id' => $this->id]),
            Url::to(['cabinet/pay/tour', 'id' => $this->id]),
            Url::to(['cabinet/tour/cancelpay', 'id' => $this->id]),
            Url::to(['tour/view', 'id' => $this->object_id]),
            Url::to(['tours/view', 'id' => $this->object_id])
        );
        return $link;
    }


    public function getPhoto(string $photo = 'cabinet_list'): string
    {
        return $this->tour->main_photo_id ? $this->tour->mainPhoto->getThumbFileUrl('file', $photo) : '';
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
        return $this->tour->user;
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