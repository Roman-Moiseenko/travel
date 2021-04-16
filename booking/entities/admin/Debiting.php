<?php


namespace booking\entities\admin;


use booking\entities\booking\tours\Tour;
use booking\entities\shops\AdShop;
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
    const DEBITING_SHOP_AP = AdShop::class;
    const DEBITING_FEATURED_TOUR = Tour::class;

    const DEBITING_LIST = [
        self::DEBITING_SHOP_AP => 'Оплата показов товара в Витрине',
        self::DEBITING_FEATURED_TOUR => 'Оплата показа экскурсии в рекомендуемых',
    ];

    public static function create($amount, $type, $link): self
    {
        $debiting = new static();
        $debiting->amount = $amount;
        $debiting->type = $type;
        $debiting->link = $link;
        $debiting->created_at = time();
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