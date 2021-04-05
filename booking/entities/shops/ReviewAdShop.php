<?php


namespace booking\entities\shops;


use booking\entities\admin\Legal;
use booking\entities\booking\BaseReview;
use yii\db\ActiveQuery;

class ReviewAdShop extends BaseReview
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
        // TODO: Implement getLinks() method.
    }

    public function getType(): int
    {
        // TODO: Implement getType() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function getAdmin(): \booking\entities\admin\User
    {
        // TODO: Implement getAdmin() method.
    }

    public function getLegal(): Legal
    {
        // TODO: Implement getLegal() method.
    }
}