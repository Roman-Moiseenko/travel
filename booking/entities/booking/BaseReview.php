<?php


namespace booking\entities\booking;


use booking\entities\admin\Legal;
use booking\entities\user\User;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property int $id
 * @property int $created_at
 * @property int $user_id
 * @property int $vote
 * @property string $text
 * @property int $status
 * @property User $user
 */

abstract class BaseReview extends ActiveRecord
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;

    final public static function create($userId, int $vote, string $text): self
    {
        $review = new static();
        $review->user_id = $userId;
        $review->vote = $vote;
        $review->text = $text;
        $review->status = self::STATUS_ACTIVE;
        $review->created_at = time() - 3600 * 24 * 0;
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

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        $this->status = self::STATUS_INACTIVE;
    }

    public function activate(): void
    {
        $this->status = self::STATUS_ACTIVE;
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

     public function getId(): int
    {
        return $this->id;
    }

    abstract public function getLinks(): array;

    public function getText(): string
    {
        return $this->text;
    }

    public function getVote(): int
    {
        return $this->vote;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getDate(): int
    {
        return $this->created_at;
    }

    abstract public function getType(): int;

    abstract public function getName(): string;

    abstract public function getAdmin(): \booking\entities\admin\User;

    abstract public function getLegal(): Legal;

   // abstract public static function getAction(): string;
}