<?php


namespace booking\helpers\cars;


use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\cars\Extra;
use booking\entities\booking\cars\ReviewCar;
use booking\helpers\BookingHelper;

class CarHelper
{

    public static function listExtra(): array
    {
        return Extra::find()->andWhere(['user_id' => \Yii::$app->user->id])->all();
    }

    public static function getCountActiveBooking($car_id): int
    {
        $bookings = BookingCar::find()->andWhere(['IN', 'status', [
            BookingHelper::BOOKING_STATUS_NEW,
            BookingHelper::BOOKING_STATUS_PAY,
            BookingHelper::BOOKING_STATUS_CONFIRMATION,
        ]
        ])
            ->andWhere(['object_id' => $car_id])
            ->andWhere(['>=', 'begin_at', time()])
            ->all();
        $count = 0;
        foreach ($bookings as $booking) {
            $count += $booking->count;
        }
        return $count;
    }

    public static function getCountReview($car_id): int
    {
        return ReviewCar::find()->andWhere(['car_id' => $car_id])->count();
    }
}