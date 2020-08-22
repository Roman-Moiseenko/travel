<?php


namespace frontend\controllers\tours;


use booking\helpers\scr;
use booking\services\booking\tours\BookingTourService;
use yii\web\Controller;

class CheckoutController extends Controller
{

    /**
     * @var BookingTourService
     */
    private $service;

    public function __construct($id, $module, BookingTourService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionBooking()
    {
        $params = \Yii::$app->request->bodyParams;
        scr::p($params);

    }
}