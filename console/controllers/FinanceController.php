<?php


namespace console\controllers;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\helpers\BookingHelper;
use booking\services\finance\PaymentService;
use booking\services\TransactionManager;
use yii\console\Controller;

class FinanceController extends Controller
{

    /**
     * @var PaymentService
     */
    private $service;
    /**
     * @var TransactionManager
     */
    private $manager;

    public function __construct($id, $module, PaymentService $service, TransactionManager $manager, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->manager = $manager;
    }

    public function actionPayment()
    {
        echo 'НАЧАЛО';
        $tours = BookingTour::find()
            ->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])
            ->andWhere(['unload' => false])
            ->andWhere([
                'IN',
                'calendar_id',
                CostCalendar::find()->select('id')->andWhere(['<=', 'tour_at', time()])
            ])->all();
        echo 'Нашлось ' . count($tours);
        foreach ($tours as $tour) {
            $tour->unload = true;
            echo 'ID = ' . $tour->id;
            $this->manager->wrap(function (BookingTour $tour) {
                $tour->save();
                $this->service->create($tour);
                echo 'Транзакция сохранения выполнена';
            });
        }
        echo 'КОНЕЦ';

        //TODO Заглушка stays, cars
    }

}