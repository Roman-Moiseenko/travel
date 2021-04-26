<?php

namespace booking\entities\foods;


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
 * @property integer $food_id
 * @property Food $food
 */
class ReviewFood extends ActiveRecord
{

    final public static function create(int $vote, string $text, string $username, string $email): self
    {
        $review = new static();
        $review->vote = $vote;
        $review->text = $text;
        $review->username = $username;
        $review->email = $email;
        $review->created_at = time();
        return $review;
    }

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
        return '{{%foods_reviews}}';
    }

    public function getFood(): ActiveQuery
    {
        return $this->hasOne(Food::class, ['id' => 'food_id']);
    }

    public function isActive(): bool
    {
        return true;
    }
}