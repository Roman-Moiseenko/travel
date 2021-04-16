<?php


namespace booking\entities\admin;


use yii\db\ActiveRecord;

/**
 * Class Debiting
 * @package booking\entities\admin
 * @property integer $id
 * @property integer $user_id
 * @property integer $created_at
 * @property float $amount
 * @property integer $type
 * @property string $link
 */

class Debiting extends ActiveRecord
{
    const DEBITING_SHOP_AP = 1;
    const DEBITING_FEATURED = 2;

    const DEBITING_LIST = [
        self::DEBITING_SHOP_AP => 'Оплата показов товара в Витрине',
        self::DEBITING_FEATURED => 'Оплата в рекомендуемых',
    ];

    public static function create($amount, $type, $link): self
    {
        $debiting = new static();
        $debiting->amount = $amount;
        $debiting->type = $type;
        $debiting->link = $link;
        return $debiting;
    }

    public static function tableName()
    {
        return '{{%admin_user_debiting}}';
    }

    public function nameType(): string
    {
        return self::DEBITING_LIST[$this->type];
    }
}