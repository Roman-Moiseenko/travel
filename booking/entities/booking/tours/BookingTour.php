<?php


namespace booking\entities\booking\tours;


use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\Discount;
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
 * @property Cost $count
 * @property integer $status
 * @property integer $created_at


 * @property integer $discount_id
 * @property Discount $discount
 * @property integer $bonus - скидка с вознаграждения портала
 * @property integer $pincode
 * @property boolean $unload
 *

Выплаты
 * @property float $payment_provider - оплата провайдеру
 * @property float $pay_merchant - % оплаты клиентом комиссии: 0 - оплачивает провайдер
 * @property string $payment_id - ID платежа по ЮКассе
 * @property integer $payment_at - дата оплаты
 * @property float $payment_merchant - оплата комиссии банку (в руб)
 * @property float $payment_deduction - оплата вознаграждения порталу (в руб)
 * @property string $confirmation - код подтверждения, для неоплачиваемых

Выдача билета
 * @property bool $give_out
 * @property integer $give_at
 * @property integer $give_user_id

 * @property \booking\entities\check\User $checkUser
 * @property \booking\entities\user\User $user
 * @property int $count_adult [int]
 * @property int $count_child [int]
 * @property int $count_preference [int]
 */

// unload - выгружен или нет для отчета в finance
class BookingTour extends ActiveRecord implements BookingItemInterface
{
    public $count;

    public static function create($calendar_id, Cost $count): self
    {
        $booking = new static();
        $booking->user_id = \Yii::$app->user->id;
        $booking->calendar_id = $calendar_id;
        $booking->count = $count;
        $booking->status = BookingHelper::BOOKING_STATUS_NEW;
        $booking->created_at = time();
        $booking->pincode = rand(1001, 9900);
        $booking->unload = false;
        return $booking;
    }

    public function edit(Cost $count): void
    {
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

    public function isConfirmation(): bool
    {
        return $this->status == BookingHelper::BOOKING_STATUS_CONFIRMATION;
    }

    public function isNew(): bool
    {
        return $this->status == BookingHelper::BOOKING_STATUS_NEW;
    }

    public function isCancel(): bool
    {
        return ($this->status == BookingHelper::BOOKING_STATUS_CANCEL || $this->status == BookingHelper::BOOKING_STATUS_CANCEL_PAY);
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

    public function setDiscount($discount_id)
    {
        $this->discount_id = $discount_id;
    }

    public function setBonus($bonus)
    {
        $this->bonus = $bonus;
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(\booking\entities\user\User::class, ['id' => 'user_id']);
    }

    /** ==========> Interface для личного кабинета */

    public function getDiscount(): ActiveQuery
    {
        return $this->hasOne(Discount::class, ['id' => 'discount_id']);
    }

    public function getCheckUser(): ActiveQuery
    {
        return $this->hasOne(\booking\entities\check\User::class, ['id' => 'give_user_id']);
    }

    /**  === Сумма базовая */
    public function getAmount(): int
    {
        return ($this->count->adult * $this->calendar->cost->adult ?? 0) +
            ($this->count->child * $this->calendar->cost->child ?? 0) +
            ($this->count->preference * $this->calendar->cost->preference ?? 0);
    }

    /**  === Сумма для оплаты (со скидкой) */
    public function getAmountDiscount(): float
    {
        if (!$this->discount) return $this->getAmount(); //Скидок нет
        if ($this->discount->isOffice()) {
            return ($this->getAmount() - $this->bonus); // - Скидка от Портала
        } else {
            return ($this->getAmount() * (1 - $this->discount->percent / 100)); // - Скидка от Провайдера
        }
    }


    /**  === Сумма которую видят партнеры, без скидки провайдера */
    public function getAmountPayAdmin(): float
    {
        if (!$this->discount) return $this->getAmount();
        if ($this->discount->isOffice()) return $this->getAmountDiscount();
        return $this->getAmount();
    }


    /** Выплата провайдеру с текущей брони */
    public function getPaymentToProvider(): float
    {
        return $this->payment_provider;
    }

    public function getDate(): int
    {
        return $this->calendar->tour_at;
    }

    public function getName(): string
    {
        return $this->calendar->tour->getName();
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['tour/common', 'id' => $this->calendar->tours_id]),
            'booking' => Url::to(['tour/booking/index', 'id' => $this->calendar->tours_id]),
            'frontend' => Url::to(['cabinet/tour/view', 'id' => $this->id]),
            'pay' => Url::to(['cabinet/pay/tour', 'id' => $this->id]),
            'cancelpay' => Url::to(['cabinet/tour/cancelpay', 'id' => $this->id]),
            'entities' => Url::to(['tour/view', 'id' => $this->calendar->tours_id]),
            'office' => Url::to(['tours/view', 'id' => $this->calendar->tours_id]),
        ];
    }

    public function getPhoto(string $photo = 'cabinet_list'): string
    {
        return $this->calendar->tour->mainPhoto->getThumbFileUrl('file', $photo);

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

    public function setStatus($status)
    {
        $this->status = $status;
        if (!$this->save()) {
            throw new \DomainException(Lang::t('Ошибка изменения статуса'));
        }
    }

    public function setPaymentId(string $payment_id)
    {
        $this->payment_id = $payment_id;
        if (!$this->save()) {
            throw new \DomainException(Lang::t('Ошибка сохранения payment_id - ') . $payment_id);
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
        $id = $this->calendar->tour->user_id;
        return User::findOne($id);
    }

    public function getLegal(): Legal
    {
        $id = $this->calendar->tour->legal_id;
        return Legal::findOne($id);
    }

    public function getCreated(): int
    {
        return $this->created_at;
    }

    public function getParentId(): int
    {
        return $this->calendar->tours_id;
    }

    public function getConfirmationCode(): string
    {
        return $this->confirmation;
    }

    public function getPinCode(): int
    {
        return $this->pincode;
    }

    public function setGive()
    {
        $this->give_out = true;
        $this->give_at = time();
    }

    public function getCount(): int
    {
        return ($this->count->adult ?? 0) + ($this->count->child ?? 0) + ($this->count->preference ?? 0);
    }

    public function isCheckBooking(): bool
    {
        return $this->calendar->tour->check_booking == BookingHelper::BOOKING_PAYMENT;
    }
}