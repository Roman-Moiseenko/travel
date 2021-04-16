<?php


namespace booking\entities\admin;


use yii\db\ActiveRecord;

/**
 * Class Deposit
 * @package booking\entities\admin
 * @property integer $id
 * @property integer $user_id
 * @property integer $created_at
 * @property float $amount
 * @property string $payment_id
 * @property boolean $payment_status
 */

class Deposit extends ActiveRecord
{
    public static function create($amount, $payment_id): self
    {
        $deposit = new static();
        $deposit->created_at = time();
        $deposit->amount = $amount;
        $deposit->payment_id = $payment_id;
        $deposit->payment_status = false;
        return $deposit;
    }

    public function setUser($id): void
    {

        $this->user_id = $id;
    }

    public function setPay(): void
    {
        $this->payment_status = true;
    }

    public function isPay(): bool
    {
        return $this->payment_status;
    }

    public static function tableName()
    {
        return '{{%admin_user_deposit}}';
    }
}