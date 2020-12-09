<?php


namespace frontend\widgets\reviews;

use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\funs\ReviewFun;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use yii\base\Widget;

class NewReviewFunWidget extends Widget
{
    public $fun_id = 0;

    public function run()
    {
        if (\Yii::$app->user->isGuest) {
            return '';
        }
        //Проверяем есть ли отзыв
        $user_id = \Yii::$app->user->id;
        $reviews = ReviewFun::find()->andWhere(['user_id' => $user_id])->andWhere(['fun_id' => $this->fun_id])->all();
        if (count($reviews) != 0) return '';


        /** @var BookingFun[] $bookings */
        $bookings = BookingFun::find()->andWhere(['user_id' => $user_id])->all();
        foreach ($bookings as $booking) {
            if ($booking->calendar->fun_at < time() &&
                $booking->fun_id == $this->fun_id &&
                ($booking->status == BookingHelper::BOOKING_STATUS_PAY || $booking->status == BookingHelper::BOOKING_STATUS_CONFIRMATION)) {
                $reviewForm = new ReviewForm();
                return $this->render('new-review-fun', [
                    'reviewForm' => $reviewForm,
                    'fun_id' => $this->fun_id,
                ]);
            }
        }
        return '';
    }
}