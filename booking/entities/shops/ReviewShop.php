<?php

namespace booking\entities\shops;


use booking\entities\admin\Legal;
use booking\entities\booking\BaseReview;
use booking\entities\user\User;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property int $id
 * @property int $created_at
 * @property int $vote
 * @property string $text
 * @property string $username
 * @property string $email
 * @property integer $shop_id
 * @property Shop $shop
 */
class ReviewShop extends BaseReview
{

    public static function tableName(): string
    {
        return '{{%shops_reviews}}';
    }

    public function getShop(): ActiveQuery
    {
        return $this->hasOne(Shop::class, ['id' => 'shop_id']);
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['shop/review/index', 'id' => $this->shop_id]),
            'frontend' => Url::to(['shop/view', 'id' => $this->shop_id]),
            'update' => Url::to(['cabinet/review/update-shop', 'id' => $this->id]),
            'remove' => Url::to(['cabinet/review/delete-shop', 'id' => $this->id]),
        ];
    }

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_SHOP;
    }

    public function getName(): string
    {
        return $this->shop->getName();
    }

    public function getAdmin(): \booking\entities\admin\User
    {
        $id = $this->shop->user_id;
        return \booking\entities\admin\User::findOne($id);
    }

    public function getLegal(): Legal
    {
        $id = $this->shop->legal_id;
        return Legal::findOne($id);
    }
}