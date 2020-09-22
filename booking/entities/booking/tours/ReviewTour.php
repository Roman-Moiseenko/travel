<?php

namespace booking\entities\booking\tours;


use booking\entities\admin\UserLegal;
use booking\entities\booking\BookingItemInterface;
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
 * @property integer $tour_id
 * @property Tour $tour
 * @property int $status
 * @property User $user
 */
class ReviewTour extends ActiveRecord implements ReviewInterface
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

    public static function tableName(): string
    {
        return '{{%booking_tours_reviews}}';
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTour(): ActiveQuery
    {
        return $this->hasOne(Tour::class, ['id' => 'tour_id']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['tour/review/index', 'id' => $this->tour_id]),
            'frontend' => Url::to(['tour/view', 'id' => $this->tour_id]),
            'update' => Url::to(['cabinet/review/update-tour', 'id' => $this->id]),
            'remove' => Url::to(['cabinet/review/delete-tour', 'id' => $this->id]),
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
        return BookingHelper::BOOKING_TYPE_TOUR;
    }

    public function getName(): string
    {
        return $this->tour->name;
    }

    /**
     * @inheritDoc
     */
    public function getAdmin(): \booking\entities\admin\User
    {
        $id = $this->tour->user_id;
        return \booking\entities\admin\User::findOne($id);
    }

    public function getLegal(): UserLegal
    {
        $id = $this->tour->legal_id;
        return UserLegal::findOne($id);
    }

}