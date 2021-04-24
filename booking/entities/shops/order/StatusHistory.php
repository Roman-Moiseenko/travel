<?php


namespace booking\entities\shops\order;


use booking\entities\Lang;
use yii\db\ActiveRecord;

/**
 * Class StatusHistory
 * @package booking\entities\shops\order
 * @property integer $id
 * @property integer $order_id
 * @property integer $status
 * @property integer $created_at
 * @property string $comment
 */
class StatusHistory extends ActiveRecord
{
    const ORDER_PREPARE = 1;
    const ORDER_NEW = 2;
    const ORDER_CONFIRMATION = 3;
    const ORDER_TO_PAY = 4;
    const ORDER_PAID = 5;
    const ORDER_FORMED = 6;
    const ORDER_SENT = 7;
    const ORDER_COMPLETED = 8;
    const ORDER_CANCELED = 9;

    const ARRAY_STATUS = [
        self::ORDER_PREPARE => 'Новый',
        self::ORDER_NEW => 'На подтверждении',
        self::ORDER_CONFIRMATION => 'Требуется оплата',
        self::ORDER_TO_PAY => 'Ждет зачисления оплаты',
        self::ORDER_PAID => 'Оплачен',
        self::ORDER_FORMED => 'Формируется',
        self::ORDER_SENT => 'Отправлен',
        self::ORDER_COMPLETED => 'Завершен',
        self::ORDER_CANCELED => 'Отменен',
    ];

    const ARRAY_ADMIN = [
        self::ORDER_NEW => 'На подтверждении',
        self::ORDER_CONFIRMATION => 'Требуется оплата',
        self::ORDER_TO_PAY => 'Ждет зачисления оплаты',
        self::ORDER_PAID => 'Оплачен',
        self::ORDER_FORMED => 'Формируется',
        self::ORDER_SENT => 'Отправлен',
        self::ORDER_COMPLETED => 'Завершен',
        self::ORDER_CANCELED => 'Отменен',
    ];

    const ARRAY_BADGE = [
        self::ORDER_PREPARE => 'secondary',
        self::ORDER_NEW => 'info',
        self::ORDER_CONFIRMATION => 'danger',
        self::ORDER_TO_PAY => 'warning',
        self::ORDER_PAID => 'success',
        self::ORDER_FORMED => 'primary',
        self::ORDER_SENT => 'primary',
        self::ORDER_COMPLETED => 'secondary',
        self::ORDER_CANCELED => 'secondary',
    ];

    public static function created($status, $comment = null): self
    {
        $history = new static();
        $history->status = $status;
        $history->comment = $comment;
        $history->created_at = time();
        return $history;
    }


    public static function tableName()
    {
        return '{{%shops_order_status}}';
    }

    public static function toString(int $current_status)
    {
        return self::ARRAY_STATUS[$current_status];
    }

    public static function toHtml(int $current_status)
    {
        $text = self::ARRAY_STATUS[$current_status];
        $badge = self::ARRAY_BADGE[$current_status];
        return '<scan class="badge badge-' . $badge . '" style="font-size: 12px">' . Lang::t($text) .'</scan>';
    }
}