<?php


namespace console\controllers;


use booking\entities\shops\order\StatusHistory;
use booking\repositories\shops\OrderRepository;
use booking\services\shops\OrderService;
use yii\console\Controller;

class OrderController extends Controller
{

    /**
     * @var OrderRepository
     */
    private $orders;
    /**
     * @var OrderService
     */
    private $orderService;


    public function __construct($id, $module, OrderRepository $orders, OrderService $orderService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->orders = $orders;
        $this->orderService = $orderService;
    }

    public function actionCancel()
    {
        $daysOfCanceledOrders = \Yii::$app->params['daysOfCanceledOrders'] ?? 7;
        $orders = $this->orders->getNotPay($daysOfCanceledOrders);
        echo 'Нашлось $stays ' . count($orders);
        foreach ($orders as $order) {
            $this->orderService->canceled($order->id, 'ООО Кёнигс.РУ: По истечению времени!', true);
            echo 'ID = ' . $order->id . PHP_EOL;
        }
        echo 'КОНЕЦ';
    }
}