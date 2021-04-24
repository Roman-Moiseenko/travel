<?php


namespace admin\widgest;

use booking\repositories\booking\BookingRepository;
use booking\repositories\shops\OrderRepository;
use yii\base\Widget;

class SellingTopBarWidget extends Widget
{


    /**
     * @var OrderRepository
     */
    private $orders;

    public function __construct(OrderRepository $orders, $config = [])
    {
        parent::__construct($config);
        $this->orders = $orders;
    }

    public function run()
    {
        $orders = $this->orders->getByUser(\Yii::$app->user->id);


        return $this->render('selling_top_bar', [
            'orders' => $orders,
        ]);
    }
}