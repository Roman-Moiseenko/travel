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

 /*   final public static function create(int $vote, string $text, string $username, string $email): self
    {
        $review = new static();
        $review->vote = $vote;
        $review->text = $text;
        $review->username = $username;
        $review->email = $email;
        $review->created_at = time();
        return $review;
    }
*/
    public function getRating(): int
    {
        return $this->vote;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

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