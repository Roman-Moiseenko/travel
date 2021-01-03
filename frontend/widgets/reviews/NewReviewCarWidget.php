<?php


namespace frontend\widgets\reviews;

use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\cars\ReviewCar;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use yii\base\Widget;

class NewReviewCarWidget extends Widget
{
    public $car_id = 0;

    public function run()
    {
        if (\Yii::$app->user->isGuest) {
            return '';
        }
        //Проверяем есть ли отзыв
        $user_id = \Yii::$app->user->id;
        $reviews = ReviewCar::find()->andWhere(['user_id' => $user_id])->andWhere(['car_id' => $this->car_id])->all();
        if (count($reviews) != 0) return '';


        /** @var BookingCar[] $bookings */
        $bookings = BookingCar::find()->andWhere(['user_id' => $user_id])->all();
        foreach ($bookings as $booking) {
            if ($booking->getDate() < time() &&
                $booking->car_id == $this->car_id &&
                ($booking->status == BookingHelper::BOOKING_STATUS_PAY || $booking->status == BookingHelper::BOOKING_STATUS_CONFIRMATION)) {
                $reviewForm = new ReviewForm();
                //scr::p(date('d-m-Y H:i:s', $booking->calendar->tour_at));

                return $this->render('new-review', [
                    'reviewForm' => $reviewForm,
                    'id' => $this->car_id,
                    'action' => '/car/view',
                ]);
            }
        }
        return '';
    }
}