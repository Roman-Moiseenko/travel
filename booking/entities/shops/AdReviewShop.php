<?php


namespace booking\entities\shops;


use booking\entities\admin\Legal;
use booking\entities\booking\BaseReview;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * Class AdReviewShop
 * @package booking\entities\shops
 * @property AdShop $shop
 * @property int $shop_id [int]
 */
class AdReviewShop extends BaseReview
{

    public static function tableName(): string
    {
        return '{{%shops_ad_reviews}}';
    }

    public function getShop(): ActiveQuery
    {
        return $this->hasOne(AdShop::class, ['id' => 'shop_id']);
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['shop-ad/review/index', 'id' => $this->shop_id]),
            'frontend' => Url::to(['shop-ad/view', 'id' => $this->shop_id]),
            'update' => Url::to(['cabinet/review/update-shop-ad', 'id' => $this->id]),
            'remove' => Url::to(['cabinet/review/delete-shop-ad', 'id' => $this->id]),
        ];
    }

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_SHOP;
    }

    public function getName(): string
    {
        return $this->shop->name;
    }

    public function getAdmin(): \booking\entities\admin\User
    {
        return $this->shop->user;
    }

    public function getLegal(): Legal
    {
        return $this->shop->legal;
    }
}