<?php


namespace booking\entities\booking\funs;

use booking\entities\admin\User;
use booking\entities\booking\BaseBooking;
use booking\entities\booking\LinkBooking;
use booking\entities\booking\tours\Cost;
use booking\helpers\BookingHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * Class BookingFun
 * @package booking\entities\booking\funs
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property string $comment - комментарий к заказу
 * @property integer $created_at

 * @property integer $pincode
 * @property boolean $unload
 * @property bool $give_out
 * @property integer $give_at
 * @property integer $give_user_id
 * @property Fun $fun
 * @property \booking\entities\check\User $checkUser
 * @property BookingFunOnDay[] $days
 * @property CostCalendar[] $calendars
 * @property int $count_adult [int]
 * @property int $count_child [int]
 * @property int $count_preference [int]
 * @property string $confirmation [varchar(255)]
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


class BookingFun extends BaseBooking
{
    /** @var $count Cost */
    public $count;

    public static function create(array $calendar_ids, Cost $count, $comment): self
    {
        if (count($calendar_ids) == 0) throw new \DomainException('Не заполнен календарь');
        $calendar = CostCalendar::findOne($calendar_ids[0]);
        $booking = new static();
        $booking->count = $count;
        $booking->comment = $comment;

        foreach ($calendar_ids as $calendar_id) {
            $booking->addDay($calendar_id);
        }

        $booking->initiate($calendar->fun_id, $calendar->fun->legal_id, \Yii::$app->user->id, $calendar->fun->prepay);
        return $booking;
    }

    public function isCancellation(): bool
    {
        return $this->fun->isCancellation($this->getDate());
    }

    public function addDay($calendar_id)
    {
        $days = $this->days;
        $days[] = BookingFunOnDay::create($calendar_id);
        $this->days = $days;
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

    public function getFun(): ActiveQuery
    {
        return $this->hasOne(Fun::class, ['id' => 'object_id']);
    }


    public function getDays(): ActiveQuery
    {
        return $this->hasMany(BookingFunOnDay::class, ['booking_id' => 'id']);
    }

    public function getCalendars(): ActiveQuery
    {
        return $this->hasMany(CostCalendar::class, ['id' => 'calendar_id'])->via('days');
    }

    public static function tableName()
    {
        return '{{%booking_funs_calendar_booking}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'days',
                ],
            ],
        ];
    }


    public function getAdmin(): User
    {
        return $this->fun->user;
    }

    public function getDate(): int
    {
        return $this->days[0]->calendar->fun_at;
    }

    public function getName(): string
    {
        return $this->fun->getName();
    }

    public function getLinks(): LinkBooking
    {
        $link = new LinkBooking(
            Url::to(['fun/common', 'id' => $this->object_id]),
            Url::to(['fun/booking/index', 'id' => $this->object_id]),
            Url::to(['cabinet/fun/view', 'id' => $this->id]),
            Url::to(['cabinet/pay/fun', 'id' => $this->id]),
            Url::to(['cabinet/fun/cancelpay', 'id' => $this->id]),
            Url::to(['fun/view', 'id' => $this->object_id]),
            Url::to(['funs/view', 'id' => $this->object_id])
        );
        return $link;
    }

    public function getPhoto(string $photo = 'cabinet_list'): string
    {
        return $this->fun->mainPhoto ? $this->fun->mainPhoto->getThumbFileUrl('file', $photo) : '';
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_FUNS;
    }

    public function getAdd(): string
    {
        $result = '';
        foreach ($this->days as $day) {
            $result .= $day->calendar->time_at . ' ';
        }
        return $result;
    }

    public function getCostClass(): Cost
    {
        $cost = new Cost();
        foreach ($this->days as $day) {
            $cost->adult += $day->calendar->cost->adult ?? 0;
            $cost->child += $day->calendar->cost->child ?? 0;
            $cost->preference += $day->calendar->cost->preference ?? 0;
        }
        return $cost;
    }

    public function quantity(): int
    {
        return (($this->count->adult ?? 0) + ($this->count->child ?? 0) + ($this->count->preference ?? 0)) * count($this->days);
    }

    public function isPaidLocally(): bool
    {
        return $this->fun->prepay == 0;
    }

    public function getCalendar(): ActiveQuery
    {
        throw new \DomainException('Не используется!');
    }

    protected function getFullCostFrom(): float
    {
        $cost = $this->getCostClass();
        return $this->count->adult * $cost->adult + $this->count->child * $cost->child + $this->count->preference * $cost->preference;
    }

    protected function getPrepayFrom(): int
    {
        return $this->fun->prepay;
    }
}