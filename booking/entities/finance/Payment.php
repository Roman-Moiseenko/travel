<?php


namespace booking\entities\finance;


use booking\entities\admin\Legal;
use booking\entities\booking\BookingItemInterface;
use booking\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Refund
 * @package booking\entities\finance
 * @property integer $id
 * @property integer $created_at
 * @property integer $payment_at
 * @property integer $booking_id
 * @property integer $legal_id
 * @property string $class_booking
 * @property float $amount
 * @property float $pay_legal
 * @property integer $status
 * @property BookingItemInterface $booking
 * @property User $user
 * @property Legal $legal
 */

class Payment extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_PAY = 1;


    public static function create($booking_id, $legal_id, $class_booking, $amount): self
    {
        $payment = new static();
        $payment->created_at = time();
        $payment->booking_id = $booking_id;
        $payment->legal_id = $legal_id;
        $payment->class_booking = $class_booking;
        $payment->amount = $amount;
        $payment->status = self::STATUS_NEW;
        return $payment;
    }

    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }

    public function isPay(): bool
    {
        return $this->status === self::STATUS_PAY;
    }

    public function pay(): void
    {
        $this->payment_at = time();
        $this->status = self::STATUS_PAY;
    }

    public static function tableName()
    {
        return '{{%payment}}';
    }

    /** get XXX */

    public function getBooking(): ActiveQuery
    {
        return $this->hasOne($this->class_booking, ['id' => 'booking_id']);
    }

    public function getUser(): User
    {
        $booking = $this->booking;
        return User::findOne($booking->getUserId());
    }

    public function getLegal(): ActiveQuery
    {
        return $this->hasOne(Legal::class, ['id' => 'legal_id']);
    }
}