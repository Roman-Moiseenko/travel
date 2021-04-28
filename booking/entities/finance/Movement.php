<?php


namespace booking\entities\finance;


use booking\entities\admin\Legal;
use booking\entities\PaymentInterface;
use booking\entities\user\User;
use booking\helpers\scr;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Movement
 * @package booking\entities\finance
 * @property integer $id
 * @property integer $legal_id
 * @property integer $user_id
 * @property integer $created_at
 * @property string $object_class
 * @property integer $object_id
 * @property string $payment_id
 * @property integer $amount
 * @property boolean $paid
 * @property Legal $legal
 * @property User $user
 */
class Movement extends ActiveRecord
{
    public static function create(PaymentInterface $object): self
    {
        $payment = new static();
        $payment->user_id = $object->getUserId();
        $payment->legal_id = $object->getLegal()->id;
        $payment->object_class = get_class($object);
        $payment->object_id = $object->getId();
        $payment->payment_id = $object->getPayment()->id;
        $payment->created_at = $object->getPayment()->date;
        $payment->amount = $object->getPayment()->prepay;
        $payment->paid = false;
        return $payment;
    }

    public function paid(): void
    {
        $this->paid = true;
    }

    public function isPaid(): bool
    {
        return $this->paid;
    }

    public static function tableName()
    {
        return '{{%finance_movement}}';
    }

    public function getLegal(): ActiveQuery
    {
        return $this->hasOne(Legal::class, ['id' => 'legal_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}