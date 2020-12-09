<?php


namespace booking\entities\booking\funs;

use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\Discount;
use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class BookingFun
 * @package booking\entities\booking\funs
 * @property integer $id
 * @property integer $user_id
 * @property integer $fun_id
 * @property integer $calendar_id
 * @property integer $status
 * @property string $comment - комментарий к заказу
 * @property Cost $count
 * @property integer $created_at


 * @property float $payment_provider
 * @property float $pay_merchant
 * @property string $payment_id
 * @property string $confirmation

 * @property integer $pincode
 * @property boolean $unload

 * @property integer $discount_id
 * @property integer $bonus

 * @property bool $give_out
 * @property integer $give_at
 * @property integer $give_user_id

 * @property Discount $discount
 * @property CostCalendar $calendar
 * @property Fun $fun
 * @property \booking\entities\check\User $checkUser
 */
class BookingFun extends ActiveRecord implements BookingItemInterface
{

    public $count;

    public static function create($fun_id, $calendar_id, Cost $count, $comment): self
    {
        $booking = new static();
        $booking->user_id = \Yii::$app->user->id;
        $booking->fun_id = $fun_id;
        $booking->calendar_id = $calendar_id;
        $booking->count = $count;
        $booking->comment = $comment;
        $booking->status = BookingHelper::BOOKING_STATUS_NEW;
        $booking->created_at = time();
        $booking->pincode = rand(1001, 9900);
        $booking->unload = false;
        return $booking;
    }

    public function isFor($id): bool
    {
        return $this->id === $id;
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

    public function countTickets(): int
    {
        return ($this->count->adult ?? 0) + ($this->count->child ?? 0) + ($this->count->preference ?? 0);
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

    public function getFun(): ActiveQuery
    {
        return $this->hasOne(Fun::class, ['id' => 'fun_id']);
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


    public static function tableName()
    {
        return '{{%booking_funs_calendar_booking}}';
    }

    /** get entities */
    public function getAdmin(): User
    {
        return $this->fun->legal->user;
    }

    public function getLegal(): Legal
    {
        return $this->fun->legal;
    }

    /** get field */
    public function getParentId(): int
    {
        return $this->fun_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): int
    {
        return $this->calendar->fun_at;
    }

    public function getCreated(): int
    {
        return $this->created_at;
    }

    public function getName(): string
    {
        return $this->fun->getName();
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['fun/common', 'id' => $this->fun_id]),
            'booking' => Url::to(['fun/booking/index', 'id' => $this->fun_id]),
            'frontend' => Url::to(['cabinet/fun/view', 'id' => $this->id]),
            'pay' => Url::to(['cabinet/pay/fun', 'id' => $this->id]),
            'cancelpay' => Url::to(['cabinet/fun/cancelpay', 'id' => $this->id]),
            'entities' => Url::to(['fun/view', 'id' => $this->fun_id]),
        ];
    }

    public function getPhoto(string $photo = 'cabinet_list'): string
    {
        return $this->fun->mainPhoto->getThumbFileUrl('file', $photo);
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_FUNS;
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
        return ($this->count->adult * $this->calendar->cost->adult ?? 0) +
            ($this->count->child * $this->calendar->cost->child ?? 0) +
            ($this->count->preference * $this->calendar->cost->preference ?? 0);
    }

    public function getAmountDiscount(): float
    {
        if (!$this->discount) return $this->getAmount(); //Скидок нет
        if ($this->discount->isOffice()) {
            return ($this->getAmount() - $this->bonus); // - Скидка от Портала
        } else {
            return ($this->getAmount() * (1 - $this->discount->percent / 100)); // - Скидка от Провайдера
        }
    }

    public function getMerchant(): float
    {
        return $this->pay_merchant;
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

    public function getConfirmationCode(): string
    {
        return $this->confirmation;
    }

    public function getPinCode(): int
    {
        return $this->pincode;
    }

    public function getCount(): int
    {
        return ($this->count->adult ?? 0) + ($this->count->child ?? 0) + ($this->count->preference ?? 0);
    }

    /** set */
    public function setStatus(int $status)
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

    public function setGive()
    {
        $this->give_out = true;
        $this->give_at = time();
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

    public function isCheckBooking(): bool
    {
        return $this->fun->check_booking == BookingHelper::BOOKING_PAYMENT;
    }

    public function isNew(): bool
    {
        return $this->status == BookingHelper::BOOKING_STATUS_NEW;
    }
}