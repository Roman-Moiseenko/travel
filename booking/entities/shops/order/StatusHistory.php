<?php


namespace booking\entities\shops\order;


use yii\db\ActiveRecord;

/**
 * Class StatusHistory
 * @package booking\entities\shops\order
 * @property integer $id
 * @property integer $order_id
 * @property integer $status
 * @property integer $created_at
 */
class StatusHistory extends ActiveRecord
{

    const ORDER_NEW = 1;
    const ORDER_CONFIRMATION = 2;
    const ORDER_TO_PAY = 3;
    const ORDER_PAID = 4;
    const ORDER_SENT = 5;
    const ORDER_COMPLETED = 6;
    const ORDER_CANCELED = 7;

    public static function created($status): self
    {
        $history = new static();
        $history->status = $status;
        $history->created_at = time();
        return $history;
    }


    public static function tableName()
    {
        return '{{%$shops_order_status}}';
    }
}