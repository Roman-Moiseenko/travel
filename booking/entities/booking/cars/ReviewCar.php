<?php

namespace booking\entities\booking\cars;


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
 * @property int $user_id
 * @property int $vote
 * @property string $text
 * @property integer $car_id
 * @property Car $car
 * @property int $status
 * @property User $user
 */
class ReviewCar extends BaseReview
{

    public static function tableName(): string
    {
        return '{{%booking_cars_reviews}}';
    }

    public function getCar(): ActiveQuery
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['car/review/index', 'id' => $this->car_id]),
            'frontend' => Url::to(['car/view', 'id' => $this->car_id]),
            'update' => Url::to(['cabinet/review/update-car', 'id' => $this->id]),
            'remove' => Url::to(['cabinet/review/delete-car', 'id' => $this->id]),
        ];
    }

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_CAR;
    }

    public function getName(): string
    {
        return $this->car->getName();
    }

    public function getAdmin(): \booking\entities\admin\User
    {
        $id = $this->car->user_id;
        return \booking\entities\admin\User::findOne($id);
    }

    public function getLegal(): Legal
    {
        $id = $this->car->legal_id;
        return Legal::findOne($id);
    }

}