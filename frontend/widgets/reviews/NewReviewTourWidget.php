<?php


namespace frontend\widgets\reviews;

use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\ReviewTour;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\services\system\LoginService;
use yii\base\Widget;

class NewReviewTourWidget extends Widget
{
    public $tour_id = 0;
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
        $test = true;
        if ($this->loginService->isGuest()) return '';
        //Проверяем есть ли отзыв
        $user_id = $this->loginService->user()->id;
        $reviews = ReviewTour::find()->andWhere(['user_id' => $user_id])->andWhere(['tour_id' => $this->tour_id])->all();
        if (count($reviews) != 0) return '';
        if ($test) {
            $reviewForm = new ReviewForm();
            return $this->render('new-review', [
                'reviewForm' => $reviewForm,
                'id' => $this->tour_id,
                'action' => '/tour/view',
            ]);
        }

        /** @var BookingTour[] $bookings */
        $bookings = BookingTour::find()->andWhere(['user_id' => $user_id])->all();
        foreach ($bookings as $booking) {
            if ($booking->getDate() < time() &&
                $booking->calendar->tours_id == $this->tour_id &&
                ($booking->status == BookingHelper::BOOKING_STATUS_PAY || $booking->status == BookingHelper::BOOKING_STATUS_CONFIRMATION)) {
                $reviewForm = new ReviewForm();

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