<?php


namespace booking\entities\booking;


use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class BookingCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $calendar_id
 * @property integer $user_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $discount_id
 * @property integer $bonus - скидка с вознаграждения портала
 * @property integer $pincode
 * @property boolean $unload
 *
 * Выплаты
 * @property float $payment_provider - оплата провайдеру
 * @property float $pay_merchant - % оплаты клиентом комиссии: 0 - оплачивает провайдер
 * @property string $payment_id - ID платежа по ЮКассе
 * @property integer $payment_at - дата оплаты
 * @property float $payment_merchant - оплата комиссии банку (в руб)
 * @property float $payment_deduction - оплата вознаграждения порталу (в руб)
 * @property string $confirmation - код подтверждения, для неоплачиваемых
 *
 * Выдача билета
 * @property bool $give_out
 * @property integer $give_at
 * @property integer $give_user_id
 GET-еры
 * @property \booking\entities\check\User $checkUser
 * @property \booking\entities\user\User $user
 * @property Discount $discount
 */
abstract class BookingObject extends ActiveRecord
{
    abstract public static function create(): self;

    abstract public function getAmount(): int;

    abstract public function getAmountDiscount(): float;

    abstract public function getAmountPayAdmin(): float;

    abstract public function getPaymentToProvider(): float;

    abstract public function getDate(): int;

    abstract public function getName(): string;

    abstract public function getLinks(): array;

    abstract public function getPhoto(string $photo = 'cabinet_list'): string;

    abstract public function getType(): string;

    abstract public function getAdd(): string;

    abstract public function getAdmin(): User;

    abstract public function getLegal(): Legal;

    abstract public function getParentId(): int;

    abstract public function getCount(): int;

    abstract public function isCheckBooking(): bool;

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

    public function getCreated(): int
    {
        return $this->created_at;
    }

    public function setGive()
    {
        $this->give_out = true;
        $this->give_at = time();
    }

    public function getConfirmationCode(): string
    {
        return $this->confirmation;
    }

    public function getPinCode(): int
    {
        return $this->pincode;
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

    public function getDiscount(): ActiveQuery
    {
        return $this->hasOne(Discount::class, ['id' => 'discount_id']);
    }

    public function getCheckUser(): ActiveQuery
    {
        return $this->hasOne(\booking\entities\check\User::class, ['id' => 'give_user_id']);
    }
}