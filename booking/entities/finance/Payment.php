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
 * @property string $class_booking
 * @property float $amount
 * @property integer $status
 * @property BookingItemInterface $booking
 * @property User $user
 * @property Legal $legal
 */

class Payment extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_PAY = 1;


    public static function create($booking_id, $class_booking, $amount): self
    {
        $refund = new static();
        $refund->created_at = time();
        $refund->booking_id = $booking_id;
        $refund->class_booking = $class_booking;
        $refund->amount = $amount;
        $refund->status = self::STATUS_NEW;
        return $refund;
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

    public function getLegal(): Legal
    {
        $booking = $this->booking;
        return $booking->getLegal();
    }
}