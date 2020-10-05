<?php


namespace console\controllers;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\helpers\BookingHelper;
use booking\services\finance\PaymentService;
use yii\console\Controller;

class FinanceController extends Controller
{

    /**
     * @var PaymentService
     */
    private $service;

    public function __construct($id, $module, PaymentService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionPayment()
    {
        $tours = BookingTour::find()
            ->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])
            ->andWhere(['unload' => false])
            ->andWhere([
                'IN',
                'calendar_id',
                CostCalendar::find()->select('id')->andWhere(['<=', 'tour_at', time()])
            ])->all();

        foreach ($tours as $tour) {
            $tour->unload = true;
            $tour->save();
            $this->service->create($tour);
        }
    }

}