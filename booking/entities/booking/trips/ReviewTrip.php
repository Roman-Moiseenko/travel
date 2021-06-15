<?php

namespace booking\entities\booking\trips;


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
 * @property integer $trip_id
 * @property Trip $trip
 * @property int $status
 * @property User $user
 */
class ReviewTrip extends BaseReview
{

    public static function tableName(): string
    {
        return '{{%booking_trips_reviews}}';
    }

    public function getTrip(): ActiveQuery
    {
        return $this->hasOne(Trip::class, ['id' => 'trip_id']);
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['trip/review/index', 'id' => $this->trip_id]),
            'frontend' => Url::to(['trip/view', 'id' => $this->trip_id]),
            'update' => Url::to(['cabinet/review/update-trip', 'id' => $this->id]),
            'remove' => Url::to(['cabinet/review/delete-trip', 'id' => $this->id]),
        ];
    }

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_TRIP;
    }

    public function getName(): string
    {
        return $this->trip->getName();
    }

    public function getAdmin(): \booking\entities\admin\User
    {
        $id = $this->trip->user_id;
        return \booking\entities\admin\User::findOne($id);
    }

    public function getLegal(): Legal
    {
        $id = $this->trip->legal_id;
        return Legal::findOne($id);
    }

}