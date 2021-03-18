<?php

namespace booking\entities\booking\funs;


use booking\entities\admin\Legal;
use booking\entities\booking\ReviewInterface;
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
 * @property integer $fun_id
 * @property Fun $fun
 * @property int $status
 * @property User $user
 */
class ReviewFun extends ActiveRecord implements ReviewInterface
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_CANCEL = 3;

    public static function create($userId, int $vote, string $text): self
    {
        $review = new static();
        $review->user_id = $userId;
        $review->vote = $vote;
        $review->text = $text;
        $review->status = self::STATUS_ACTIVE;
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


    public static function tableName(): string
    {
        return '{{%booking_funs_reviews}}';
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getFun(): ActiveQuery
    {
        return $this->hasOne(Fun::class, ['id' => 'fun_id']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['fun/review/index', 'id' => $this->fun_id]),
            'frontend' => Url::to(['fun/view', 'id' => $this->fun_id]),
            'update' => Url::to(['cabinet/review/update-fun', 'id' => $this->id]),
            'remove' => Url::to(['cabinet/review/delete-fun', 'id' => $this->id]),
        ];
    }

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

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_FUNS;
    }

    public function getName(): string
    {
        return $this->fun->getName();
    }

    /**
     * @inheritDoc
     */
    public function getAdmin(): \booking\entities\admin\User
    {
        $id = $this->fun->user_id;
        return \booking\entities\admin\User::findOne($id);
    }

    public function getLegal(): Legal
    {
        $id = $this->fun->legal_id;
        return Legal::findOne($id);
    }

}