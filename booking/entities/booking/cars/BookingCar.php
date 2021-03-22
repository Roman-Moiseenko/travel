<?php


namespace booking\entities\booking\cars;


use booking\entities\admin\User;
use booking\entities\booking\BaseBooking;
use booking\entities\booking\LinkBooking;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * Class BookingCar
 * @package booking\entities\booking\cars
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $begin_at
 * @property integer $end_at
 *
* Выплаты
 * @property integer $pincode
 * @property boolean $unload
 * @property integer $count
 * @property string $comment - адреса доставки и откуда забирать
 * @property integer $delivery
 *
* Выдача билета
 * @property bool $give_out
 * @property integer $give_at
 * @property integer $give_user_id
 * @property CostCalendar[] $calendars
 * @property BookingCarOnDay[] $days
 * @property Car $car
 * @property \booking\entities\user\User $user
 * @property \booking\entities\check\User $checkUser
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


class BookingCar extends BaseBooking
{

    public static function create($car_id, $comment, $begin_at, $end_at, $count, $delivery): self
    {
        $booking = new static();
        $booking->comment = $comment;
        $booking->begin_at = $begin_at;
        $booking->end_at = $end_at;
        $booking->count = $count;
        $booking->delivery = $delivery;

        $calendars = CostCalendar::find()->andWhere(['car_id' => $car_id])->andWhere(['>=', 'car_at', $begin_at])->andWhere(['<=', 'car_at', $end_at])->all();
        if (count($calendars) == 0) throw new \DomainException(Lang::t('Неверный диапозон дат'));
        foreach ($calendars as $calendar) {
            if ($calendar->free() < $count) {
                throw new \DomainException(Lang::t('Недостаточно свободных на дату ') . date('d-m-Y', $calendar->car_at));
            };
            $booking->addDay($calendar->id);
        }

        $booking->initiate(
            $calendars[0]->car_id,
            $calendars[0]->car->legal_id,
            \Yii::$app->user->id,
            $calendars[0]->car->prepay
        );

        return $booking;
    }

    public function addDay($calendar_id)
    {
        $days = $this->days;
        $days[] = BookingCarOnDay::create($calendar_id);
        $this->days = $days;
    }

    public function getCar(): ActiveQuery
    {
        return $this->hasOne(Car::class, ['id' => 'object_id']);
    }

    public function getCalendars(): ActiveQuery
    {
        return $this->hasMany(CostCalendar::class, ['id' => 'calendar_id'])->via('days');
    }

    public function getDays(): ActiveQuery
    {
        return $this->hasMany(BookingCarOnDay::class, ['booking_id' => 'id']);
    }


    public static function tableName()
    {
        return '{{%booking_cars_calendar_booking}}';
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

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    /** ==========> Interface для личного кабинета */


    public function getDate(): int
    {
        /*$min = 0;
        foreach ($this->days as $i => $day) {
            if ($i == 0) $min = $day->calendar->car_at;
            if ($day->calendar->car_at < $min) {
                $min = $day->calendar->car_at;
            }
        }*/
        return $this->begin_at;
    }

    public function getName(): string
    {
        return $this->car->getName();
    }

    public function getLinks(): LinkBooking
    {
        $link = new LinkBooking(
            Url::to(['car/common', 'id' => $this->object_id]),
            Url::to(['car/booking/index', 'id' => $this->object_id]),
            Url::to(['cabinet/car/view', 'id' => $this->id]),
            Url::to(['cabinet/pay/car', 'id' => $this->id]),
            Url::to(['cabinet/car/cancelpay', 'id' => $this->id]),
            Url::to(['car/view', 'id' => $this->object_id]),
            Url::to(['cars/view', 'id' => $this->object_id])
        );
        return $link;
    }

    public function getPhoto(string $photo = 'cabinet_list'): string
    {
        return $this->car->mainPhoto ? $this->car->mainPhoto->getThumbFileUrl('file', $photo) : '';
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_CAR;
    }

    public function getAdd(): string
    {
        return date('d-m-Y', $this->end_at);
    }

    public function getAdmin(): User
    {
        return $this->car->user;
    }

    public function getAmount(): int
    {
        $amount = 0;
        foreach ($this->days as $day) {
            $amount += $day->calendar->cost * $this->count;
        }
        if ($this->car->discount_of_days && count($this->days) > 3) return $amount = $amount * (1 - $this->car->discount_of_days / 100);
        return $amount;
    }

    public function quantity(): int
    {
        return $this->count;
    }

    public function isPaidLocally(): bool
    {
        return $this->car->prepay == 0;
    }

    public function getCalendar(): ActiveQuery
    {
        throw new \DomainException('Не используется!');
    }

    protected function getFullCostFrom(): float
    {
        $amount = 0;
        foreach ($this->days as $day) {
            $amount += $day->calendar->cost * $this->count;
        }
        if ($this->car->discount_of_days && count($this->days) > 3) return $amount = $amount * (1 - $this->car->discount_of_days / 100);
        return $amount * $this->quantity();
    }

    protected function getPrepayFrom(): int
    {
        return $this->car->prepay;
    }
}