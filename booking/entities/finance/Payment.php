<?php


namespace booking\entities\finance;


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
        $this->refund_at = time();
        $this->status = self::STATUS_PAY;
    }

    public static function tableName()
    {
        return '{{%payment}}';
    }
}