<?php

namespace booking\entities\booking\tours;


use booking\entities\admin\Legal;
use booking\entities\booking\BaseReview;
use booking\entities\user\User;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
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
class ReviewTour extends BaseReview
{

    public static function tableName(): string
    {
        return '{{%booking_tours_reviews}}';
    }

    public function getTour(): ActiveQuery
    {
        return $this->hasOne(Tour::class, ['id' => 'tour_id']);
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

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_TOUR;
    }

    public function getName(): string
    {
        return $this->tour->getName();
    }

    public function getAdmin(): \booking\entities\admin\User
    {
        $id = $this->tour->user_id;
        return \booking\entities\admin\User::findOne($id);
    }

    public function getLegal(): Legal
    {
        $id = $this->tour->legal_id;
        return Legal::findOne($id);
    }

}