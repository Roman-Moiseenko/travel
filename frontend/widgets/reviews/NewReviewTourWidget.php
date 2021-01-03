<?php


namespace frontend\widgets\reviews;

use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\ReviewTour;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use yii\base\Widget;

class NewReviewTourWidget extends Widget
{
    public $tour_id = 0;

    public function run()
    {
        if (\Yii::$app->user->isGuest) {
            return '';
        }
        //Проверяем есть ли отзыв
        $user_id = \Yii::$app->user->id;
        $reviews = ReviewTour::find()->andWhere(['user_id' => $user_id])->andWhere(['tour_id' => $this->tour_id])->all();
        if (count($reviews) != 0) return '';


        /** @var BookingTour[] $bookings */
        $bookings = BookingTour::find()->andWhere(['user_id' => $user_id])->all();
        foreach ($bookings as $booking) {
            if ($booking->getDate() < time() &&
                $booking->calendar->tours_id == $this->tour_id &&
                ($booking->status == BookingHelper::BOOKING_STATUS_PAY || $booking->status == BookingHelper::BOOKING_STATUS_CONFIRMATION)) {
                $reviewForm = new ReviewForm();
                //scr::p(date('d-m-Y H:i:s', $booking->calendar->tour_at));

                return $this->render('new-review', [
                    'reviewForm' => $reviewForm,
                    'id' => $this->tour_id,
                    'action' => '/tour/view',
                ]);
            }
        }
        return '';
    }
}