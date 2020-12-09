<?php


namespace console\controllers;


use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\tours\BookingTour;

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
                \booking\entities\booking\tours\CostCalendar::find()->select('id')->andWhere(['<=', 'tour_at', time()])
            ])->all();
        echo 'Нашлось ' . count($tours);
        foreach ($tours as $tour) {
            $tour->unload = true;
            echo 'ID = ' . $tour->id;
            //$this->manager->wrapNotSession(function ($tour) {
                $tour->save();
                $this->service->create($tour);
                echo 'Транзакция сохранения выполнена';
            //});
        }
        echo 'КОНЕЦ';

        $cars = BookingCar::find()
            ->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])
            ->andWhere(['unload' => false])
            ->andWhere(['<=', 'begin_at', time()])->all();
        echo 'Нашлось ' . count($cars);
        foreach ($cars as $car) {
            $car->unload = true;
            echo 'ID = ' . $car->id;
            //$this->manager->wrapNotSession(function ($tour) {
            $car->save();
            $this->service->create($car);
            echo 'Транзакция сохранения выполнена';
            //});
        }
        echo 'КОНЕЦ';

        $funs = BookingFun::find()
            ->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])
            ->andWhere(['unload' => false])
            ->andWhere([
                'IN',
                'calendar_id',
                \booking\entities\booking\funs\CostCalendar::find()->select('id')->andWhere(['<=', 'fun_at', time()])
            ])->all();

        echo 'Нашлось ' . count($funs);
        foreach ($funs as $fun) {
            $fun->unload = true;
            echo 'ID = ' . $fun->id;
            //$this->manager->wrapNotSession(function ($tour) {
            $fun->save();
            $this->service->create($fun);
            echo 'Транзакция сохранения выполнена';
            //});
        }
        //TODO Заглушка stays
    }

}