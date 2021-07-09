<?php


namespace frontend\widgets\reviews;

use booking\entities\booking\trips\BookingTrip;
use booking\entities\booking\trips\ReviewTrip;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\services\system\LoginService;
use yii\base\Widget;

class NewReviewTripWidget extends Widget
{
    public $trip_id = 0;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(LoginService $loginService, $config = [])
    {
        parent::__construct($config);
        $this->loginService = $loginService;
    }

    public function run()
    {
        return 'РЕЖИМ ТЕСТИРОВАНИЯ class NewReviewTripWidget';
        //$test =  ?? false;
        if ($this->loginService->isGuest()) return '';
        //Проверяем есть ли отзыв
        $user_id = $this->loginService->user()->id;
        $reviews = ReviewTrip::find()->andWhere(['user_id' => $user_id])->andWhere(['trip_id' => $this->trip_id])->all();
        if (count($reviews) != 0) return '';
        if (isset(\Yii::$app->params['bot_review']) && \Yii::$app->params['bot_review']) {
            $reviewForm = new ReviewForm();
            return $this->render('new-review', [
                'reviewForm' => $reviewForm,
                'id' => $this->trip_id,
                'action' => '/trip/view',
            ]);
        }

        /** @var BookingTrip[] $bookings */
        $bookings = BookingTrip::find()->andWhere(['user_id' => $user_id])->all();
        foreach ($bookings as $booking) {
            if ($booking->getDate() < time() &&
                $booking->calendar->trip_id == $this->trip_id &&
                ($booking->status == BookingHelper::BOOKING_STATUS_PAY || $booking->status == BookingHelper::BOOKING_STATUS_CONFIRMATION)) {
                $reviewForm = new ReviewForm();

                return $this->render('new-review', [
                    'reviewForm' => $reviewForm,
                    'id' => $this->trip_id,
                    'action' => '/trip/view',
                ]);
            }
        }
        return '';
    }
}