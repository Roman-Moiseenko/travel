<?php


namespace booking\entities\booking\cars;


use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\Discount;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class BookingCar
 * @package booking\entities\booking\cars
 * @property integer $id
 * @property integer $user_id
 * @property integer $car_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $begin_at
 * @property integer $end_at

 Выплаты
 * @property float $payment_provider - оплата провайдеру
 * @property float $pay_merchant - % оплаты клиентом комиссии: 0 - оплачивает провайдер
 * @property string $payment_id - ID платежа по ЮКассе
 * @property integer $payment_at - дата оплаты
 * @property float $payment_merchant - оплата комиссии банку (в руб)
 * @property float $payment_deduction - оплата вознаграждения порталу (в руб)
 * @property string $confirmation - код подтверждения, для неоплачиваемых

 * @property integer $pincode
 * @property boolean $unload


 * @property integer $discount_id
 * @property integer $count
 * @property string $comment - адреса доставки и откуда забирать
 * @property Discount $discount
 * @property integer $bonus
 * @property integer $delivery

Выдача билета
 * @property bool $give_out
 * @property integer $give_at
 * @property integer $give_user_id

 * @property CostCalendar[] $calendars
 * @property BookingCarOnDay[] $days
 * @property Car $car
 * @property \booking\entities\user\User $user
 * @property \booking\entities\check\User $checkUser
 */


class BookingCar extends ActiveRecord implements BookingItemInterface
{

    public static function create($car_id, $comment, $begin_at, $end_at, $count, $delivery): self
    {
        $booking = new static();
        $booking->car_id = $car_id;
        $booking->comment = $comment;
        $booking->user_id = \Yii::$app->user->id;
        $booking->status = BookingHelper::BOOKING_STATUS_NEW;
        $booking->created_at = time();
        $booking->begin_at = $begin_at;
        $booking->end_at = $end_at;
        $booking->count = $count;
        $booking->pincode = rand(1001, 9900);
        $booking->unload = false;
        $booking->delivery = $delivery;
        return $booking;
    }

    public function addDay($calendar_id)
    {
        $days = $this->days;
        $days[] = BookingCarOnDay::create($calendar_id);
        $this->days = $days;
    }

    public function isFor($id): bool
    {
        return $this->id === $id;
    }

    public function isNew(): bool
    {
        return $this->status == BookingHelper::BOOKING_STATUS_NEW;
    }

    public function setDiscount($discount_id)
    {
        $this->discount_id = $discount_id;
    }

    public function setBonus($bonus)
    {
        $this->bonus = $bonus;
    }

    public function pay()
    {
        $this->status = BookingHelper::BOOKING_STATUS_PAY;
    }

    public function confirmation()
    {
        $this->status = BookingHelper::BOOKING_STATUS_CONFIRMATION;
    }

    public function cancel()
    {
        $this->status = BookingHelper::BOOKING_STATUS_CANCEL;
    }

    public function cancelPay()
    {
        $this->status = BookingHelper::BOOKING_STATUS_CANCEL_PAY;
    }

    public function getCar(): ActiveQuery
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
    }

    public function getCalendars(): ActiveQuery
    {
        return $this->hasMany(CostCalendar::class, ['id' => 'calendar_id'])->via('days');
    }

    public function getDays(): ActiveQuery
    {
        return $this->hasMany(BookingCarOnDay::class, ['booking_id' => 'id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(\booking\entities\user\User::class, ['id' =>  'user_id']);
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

    public function getDiscount(): ActiveQuery
    {
        return $this->hasOne(Discount::class, ['id' => 'discount_id']);
    }

    public function getCheckUser(): ActiveQuery
    {
        return $this->hasOne(\booking\entities\check\User::class, ['admin_id' => 'id']);
    }

    public function getDate(): int
    {
        $min = 0;
        foreach ($this->days as $i => $day) {
            if ($i == 0) $min = $day->calendar->car_at;
            if ($day->calendar->car_at < $min) {
                $min = $day->calendar->car_at;
            }
        }
        return $this->begin_at;
    }

    public function getName(): string
    {
        return $this->car->getName();
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['car/common', 'id' => $this->car_id]),
            'booking' => Url::to(['car/booking/index', 'id' => $this->car_id]),
            'frontend' => Url::to(['cabinet/car/view', 'id' => $this->id]),
            'pay' => Url::to(['cabinet/pay/car', 'id' => $this->id]),
            'cancelpay' => Url::to(['cabinet/car/cancelpay', 'id' => $this->id]),
            'entities' => Url::to(['car/view', 'id' => $this->car_id]),
            'office' => Url::to(['cars/view', 'id' => $this->car_id]),
        ];
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

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        if (!$this->save()) {
            throw new \DomainException(Lang::t('Ошибка изменения статуса'));
        }
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAdmin(): User
    {
        return $this->car->legal->user;
    }

    public function getLegal(): Legal
    {
        return $this->car->legal;
    }

    public function getCreated(): int
    {
        return $this->created_at;
    }

    public function getParentId(): int
    {
        return $this->car_id;
    }

    public function getConfirmationCode(): string
    {
        return $this->confirmation;
    }

    public function getPinCode(): int
    {
        return $this->pincode;
    }

    public function setPaymentId(string $payment_id)
    {
        $this->payment_id = $payment_id;
        if (!$this->save()) {
            throw new \DomainException(Lang::t('Ошибка сохранения payment_id - ') . $payment_id);
        }
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

    public function getAmountDiscount(): float
    {
        $amount = $this->getAmount();
            if (!$this->discount) return $amount;//Скидок нет в этот день
            if ($this->discount->isOffice()) {
                return $amount - $this->bonus;
            } else {
                return $amount * (1 - $this->discount->percent /100);
            }
    }


    public function getAmountPayAdmin(): float
    {
        if (!$this->discount) return $this->getAmount();
        if ($this->discount->isOffice()) return $this->getAmountDiscount();
        return $this->getAmount();
    }

    public function getPaymentToProvider(): float
    {
        return $this->payment_provider;
    }

    /** is.. */
    public function isPay(): bool
    {
        return $this->status == BookingHelper::BOOKING_STATUS_PAY;
    }

    public function isConfirmation(): bool
    {
        return $this->status == BookingHelper::BOOKING_STATUS_CONFIRMATION;
    }

    public function isCancel(): bool
    {
        return ($this->status == BookingHelper::BOOKING_STATUS_CANCEL || $this->status == BookingHelper::BOOKING_STATUS_CANCEL_PAY);
    }

    public function setGive()
    {
        $this->give_out = true;
        $this->give_at = time();
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function isCheckBooking(): bool
    {
        return $this->car->check_booking == BookingHelper::BOOKING_PAYMENT;
    }
}