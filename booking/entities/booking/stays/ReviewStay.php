<?php

namespace booking\entities\booking\stays;


use booking\entities\admin\Legal;
use booking\entities\booking\BaseReview;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * @property int $id
 * @property int $created_at
 * @property int $user_id
 * @property int $vote
 * @property string $text
 * @property integer $stay_id
 * @property Stay $stay
 */

class ReviewStay extends BaseReview
{

    public static function tableName(): string
    {
        return '{{%booking_stays_reviews}}';
    }

    public function getStay(): ActiveQuery
    {
        return $this->hasOne(Stay::class, ['id' => 'stay_id']);
    }

    public function getAdmin(): \booking\entities\admin\User
    {
        return $this->stay->user;
    }

    public function getLegal(): Legal
    {
        return $this->stay->legal;
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['stay/review/index', 'id' => $this->stay_id]),
            'frontend' => Url::to(['stay/view', 'id' => $this->stay_id]),
            'update' => Url::to(['cabinet/review/update-stay', 'id' => $this->id]),
            'remove' => Url::to(['cabinet/review/delete-stay', 'id' => $this->id]),
        ];
    }

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_STAY;
    }

    public function getName(): string
    {
        return $this->stay->getName();
    }
}