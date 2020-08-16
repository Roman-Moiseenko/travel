<?php

namespace booking\entities\booking\tours;


use booking\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $created_at
 * @property int $user_id
 * @property int $vote
 * @property string $text
 * @property integer $tours_id
 */
class Review extends ActiveRecord
{
    public static function create($userId, int $vote, string $text): self
    {
        $review = new static();
        $review->user_id = $userId;
        $review->vote = $vote;
        $review->text = $text;
        $review->created_at = time();
        return $review;
    }

    public function edit($vote, $text): void
    {
        $this->vote = $vote;
        $this->text = $text;
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
        return '{{%booking_tours_reviews}}';
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTours(): ActiveQuery
    {
        return $this->hasOne(Tour::class, ['id' => 'tours_id']);
    }
}