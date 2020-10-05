<?php


namespace console\controllers;


use booking\services\booking\tours\BookingTourService;
use yii\console\Controller;

class BookingController extends Controller
{

    private $serviceTour;
    private $serviceStay;
    private $serviceCar;

    public function __construct(
        $id,
        $module,
        BookingTourService $serviceTour,
 //       BookingStayService $serviceStay,
 //       BookingCarService $serviceCar,

        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->serviceTour = $serviceTour;
//        $this->serviceStay = $serviceStay;
//        $this->serviceCar = $serviceCar;
    }

    public function actionCancel()
    {
        $this->serviceTour->cancelNotPay(1);
  //      $this->serviceStay->cancelNotPay(1);
 //       $this->serviceCar->cancelNotPay(1);
    }
}