<?php


namespace frontend\widgets\reviews;


use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\stays\ReviewStay;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\services\system\LoginService;
use yii\base\Widget;

class NewReviewStayWidget extends Widget
{
    public $stay_id = 0;
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
        if ($this->loginService->isGuest()) return '';
        //Проверяем есть ли отзыв
        $user_id = $this->loginService->user()->id;
        $reviews = ReviewStay::find()->andWhere(['user_id' => $user_id])->andWhere(['stay_id' => $this->stay_id])->all();
        if (count($reviews) != 0) return '';


        /** @var BookingStay[] $bookings */
        $bookings = BookingStay::find()->andWhere(['user_id' => $user_id])->all();
        foreach ($bookings as $booking) {
            if ($booking->getDate() < time() &&
                $booking->object_id == $this->stay_id &&
                ($booking->status == BookingHelper::BOOKING_STATUS_PAY || $booking->status == BookingHelper::BOOKING_STATUS_CONFIRMATION)) {
                $reviewForm = new ReviewForm();
                return $this->render('new-review', [
                    'reviewForm' => $reviewForm,
                    'id' => $this->stay_id,
                    'action' => '/stay/view',
                ]);
            }
        }
        return '';
    }
}