<?php


namespace booking\entities\vmuseum;

use yii\db\ActiveRecord;

/**
 * Class AccessPaid
 * @package booking\entities\vmuseum
 * @property integer $id
 * @property integer $user_id
 * @property integer $vmuseum_id
 * @property integer $created_at
 * @property string $payment_id
 * @property bool $paid
 */
class AccessPaid extends ActiveRecord
{
    public static function create($vmuseum_id, $user_id): self
    {
        $access = new static();
        $access->vmuseum_id = $vmuseum_id;
        $access->user_id = $user_id;
        $access->created_at = time();
        $access->paid = false;
        return $access;
    }

    public function payment($payment_id): void
    {
        $this->payment_id = $payment_id;
        $this->paid = true;
    }

    public function isPaid(): bool
    {
        return $this->paid;
    }

    public static function tableName()
    {
        return '{{%vmuseum_access_paid}}';
    }
}