<?php


namespace console\controllers;


use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\tours\BookingTour;

use booking\entities\shops\order\Order;
use booking\entities\shops\order\StatusHistory;
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
                \booking\entities\booking\tours\CostCalendar::find()->select('id')
                ->andWhere(['<=', 'tour_at', time()])
            ])->all();
        echo 'Нашлось ' . count($tours);
        foreach ($tours as $tour) {
            $tour->unload = true;
            echo 'ID $tour = ' . $tour->id . '<b>';
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
            ->andWhere(['<=', 'begin_at', time()])
            ->all();
        echo 'Нашлось ' . count($cars);
        foreach ($cars as $car) {
            $car->unload = true;
            echo 'ID $car = ' . $car->id . '<b>';
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
                \booking\entities\booking\funs\CostCalendar::find()->select('id')
                    ->andWhere(['<=', 'fun_at', time()])
            ])->all();

        echo 'Нашлось ' . count($funs);
        foreach ($funs as $fun) {
            $fun->unload = true;
            echo 'ID $fun = ' . $fun->id . '<b>';
            //$this->manager->wrapNotSession(function ($tour) {
            $fun->save();
            $this->service->create($fun);
            echo 'Транзакция сохранения выполнена';
            //});
        }

        $stays = BookingStay::find()
            ->andWhere(['status' => BookingHelper::BOOKING_STATUS_PAY])
            ->andWhere(['unload' => false])
            ->andWhere(['<=', 'begin_at', time()])
            ->all();
        echo 'Нашлось ' . count($stays);
        foreach ($stays as $stay) {
            $stay->unload = true;
            echo 'ID $stay = ' . $stay->id . '<b>';
            $stay->save();
            $this->service->create($stay);
            echo 'Транзакция сохранения выполнена';

        }
        echo 'КОНЕЦ';
        //TODO ** BOOKING_OBJECT **

        $orders = Order::find()
            ->andWhere(['current_status' => StatusHistory::ORDER_COMPLETED])
            ->andWhere(['unload' => false])
            ->all();
        echo 'Нашлось ' . count($orders);
        foreach ($orders as $order) {
            $order->unload = true;
            echo 'ID $order = ' . $order->id . '<b>';
            $order->save();
            $this->service->create($order);
            echo 'Транзакция сохранения выполнена';

        }
        echo 'КОНЕЦ';
    }

}