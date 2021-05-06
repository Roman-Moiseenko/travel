<?php


namespace booking\entities\booking;


use booking\entities\admin\Legal;
use booking\entities\admin\User;
use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\entities\PaymentInterface;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class BaseBooking
 * @package booking\entities\booking
 * @property integer $id
 * @property integer $object_id - заменить во всех таблицах и объектах на текущий
 * @property integer $user_id
 * @property integer $legal_id
 * @property integer $status
 * @property string $comment - комментарий к заказу
 * @property integer $created_at
 *
 * Выплаты (Составное поле)
 * @property Payment $payment
 *
 * @property integer $pincode
 * @property boolean $unload
 *
 * @property bool $give_out
 * @property integer $give_at
 * @property integer $give_user_id
 * @property User $user
 */
abstract class BaseBooking extends ActiveRecord implements PaymentInterface
{
    public $payment;

    abstract public function getAdmin(): User;

    abstract public function getDate(): int;

    abstract public function getName(): string;

    abstract public function getLinks(): LinkBooking;

    abstract public function getPhoto(string $photo = ''): string;

    abstract public function getType(): string;

    abstract public function getAdd(): string;

    abstract public function quantity(): int;

    abstract public function isPaidLocally(): bool; //Оплата через сайт (false) или на месте (true) предыдущая версия isCheckBooking переименовать isPaidLocally

    abstract public function getCalendar(): ActiveQuery;

    abstract public function getCalendars(): ActiveQuery;

    abstract public function getDays(): ActiveQuery;

    abstract protected function getFullCostFrom(): float;

    abstract protected function getPrepayFrom(): int;

//*************************** SET-s

    protected function initiate($object_id, $legal_id, $user_id, $prepay_percent)
    {
        $this->object_id = $object_id;
        $this->legal_id = $legal_id;
        $this->user_id = $user_id;
        $this->status = BookingHelper::BOOKING_STATUS_NEW;
        $this->created_at = time();
        $this->pincode = rand(1001, 9900);
        $this->unload = false;
        $this->payment = new Payment();

        $deduction = \Yii::$app->params['deduction'];
        $merchant = \Yii::$app->params['merchant'];
        $this->payment->full_cost = $this->getFullCostFrom();
        $this->payment->percent = $prepay_percent;
        $this->payment->prepay = $this->payment->percent * $this->payment->full_cost / 100;

        $this->payment->merchant = $this->payment->prepay * $merchant / 100; //
        $this->payment->deduction = $this->payment->full_cost * $deduction / 100;
        $this->payment->provider = $this->payment->prepay - $this->payment->merchant - $this->payment->deduction;
    }

    public function pay()
    {
        $this->status = BookingHelper::BOOKING_STATUS_PAY;
        $this->payment->date = time();
    }

    public function setConfirmation($confirmation): void
    {
        $this->payment->confirmation = $confirmation;
    }

    final public function confirmation()
    {
        $this->status = BookingHelper::BOOKING_STATUS_CONFIRMATION;
    }

    final public function cancel()
    {
        $this->status = BookingHelper::BOOKING_STATUS_CANCEL;
    }

    public function cancelPay()
    {
        $this->status = BookingHelper::BOOKING_STATUS_CANCEL_PAY;

    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
        if (!$this->save()) {
            throw new \DomainException(Lang::t('Ошибка изменения статуса'));
        }
    }

    public function setPaymentId(string $payment_id): void
    {
        $this->payment->id = $payment_id;
        $this->payment->date = time();
        if (!$this->save()) {
            throw new \DomainException(Lang::t('Ошибка сохранения payment_id - ') . $payment_id);
        }
    }

    public function setGive(): void
    {
        $this->give_out = true;
        $this->give_at = time();
    }


//*************************** GET-s

    public function getLegal(): Legal
    {
        return Legal::findOne($this->legal_id);
    }

    public function getParentId(): int //return id Tour/Stay/Car
    {
        return $this->object_id;
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

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }

    public function getConfirmationCode():? string
    {
        return $this->payment->confirmation;
    }

    public function getPinCode(): int
    {
        return $this->pincode;
    }

//***************************  is..

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

    public function isCancel(): bool
    {
        return ($this->status == BookingHelper::BOOKING_STATUS_CANCEL || $this->status == BookingHelper::BOOKING_STATUS_CANCEL_PAY);
    }

    public function isNew(): bool
    {
        return $this->status == BookingHelper::BOOKING_STATUS_NEW;
    }

//*************************** Внешние связи

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(\booking\entities\user\User::class, ['id' => 'user_id']);
    }

    /** ==========> Interface для личного кабинета */

    public function getCheckUser(): ActiveQuery
    {
        return $this->hasOne(\booking\entities\check\User::class, ['id' => 'give_user_id']);
    }

//*************************** Чтение/запись составных полей
    public function afterFind(): void
    {
        $this->payment = new Payment(
            $this->getAttribute('payment_full_cost'),
            $this->getAttribute('payment_id'),
            $this->getAttribute('payment_date'),
            $this->getAttribute('payment_prepay'),
            $this->getAttribute('payment_percent'),
            $this->getAttribute('payment_provider'),
            $this->getAttribute('payment_merchant'),
            $this->getAttribute('payment_deduction'),
            $this->getAttribute('payment_confirmation'),
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('payment_full_cost', $this->payment->full_cost);
        $this->setAttribute('payment_id', $this->payment->id);
        $this->setAttribute('payment_date', $this->payment->date);
        $this->setAttribute('payment_prepay', $this->payment->prepay);
        $this->setAttribute('payment_percent', $this->payment->percent);
        $this->setAttribute('payment_provider', $this->payment->provider);
        $this->setAttribute('payment_merchant', $this->payment->merchant);
        $this->setAttribute('payment_deduction', $this->payment->deduction);
        $this->setAttribute('payment_confirmation', $this->payment->confirmation);

        return parent::beforeSave($insert);
    }
}