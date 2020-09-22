<?php

namespace booking\entities\booking\stays;


use booking\entities\admin\UserLegal;
use booking\entities\booking\ReviewInterface;
use booking\entities\user\User;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $created_at
 * @property int $user_id
 * @property int $vote
 * @property string $text
 * @property integer $stays_id
 */
//TODO  В разработке

class ReviewStay extends ActiveRecord implements ReviewInterface
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
        return '{{%booking_stays_reviews}}';
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getStays(): ActiveQuery
    {
        return $this->hasOne(Stay::class, ['id' => 'stays_id']);
    }

    /**
     * @inheritDoc
     */
    public function getAdmin(): \booking\entities\admin\User
    {
        // TODO: Implement getAdmin() method.
    }

    public function getLegal(): UserLegal
    {
        // TODO: Implement getLegal() method.
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        // TODO: Implement getId() method.
    }

    public function getLinks(): array
    {
        // TODO: Implement getLinks() method.
    }

    public function getText(): string
    {
        // TODO: Implement getText() method.
    }

    public function getVote(): string
    {
        // TODO: Implement getVote() method.
    }

    public function getUserId(): string
    {
        // TODO: Implement getUserId() method.
    }

    public function getDate(): int
    {
        return $this->created_at;
    }

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_STAY;
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }
}