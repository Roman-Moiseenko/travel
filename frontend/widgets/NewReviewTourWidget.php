<?php


namespace frontend\widgets;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\ReviewTour;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\repositories\booking\tours\BookingTourRepository;
use yii\base\Widget;

class NewReviewTourWidget extends Widget
{
    public $tour_id = 0;

    public function run()
    {
        if (\Yii::$app->user->isGuest) {
            return;
        }
        //Проверяем есть ли отзыв
        $user_id = \Yii::$app->user->id;
        $reviews = ReviewTour::find()->andWhere(['user_id' => $user_id])->andWhere(['tour_id' => $this->tour_id])->all();
        if (count($reviews) != 0) {
            return;
        }

        /** @var BookingTour[] $bookings */
        $bookings = BookingTour::find()->andWhere(['user_id' => $user_id])->all();
        foreach ($bookings as $booking) {
            if ($booking->calendar->tour_at < time() && $booking->calendar->tours_id == $this->tour_id && $booking->status == BookingHelper::BOOKING_STATUS_PAY) {
                $reviewForm = new ReviewForm();
                //scr::p(date('d-m-Y H:i:s', $booking->calendar->tour_at));

                return $this->render('new-review-tour', [
                    'reviewForm' => $reviewForm,
                    'tour_id' => $this->tour_id,
                ]);
            }
        }
        return;
    }
}