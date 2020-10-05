<?php


namespace console\controllers;


use booking\entities\booking\tours\BookingTour;
use booking\repositories\booking\BookingRepository;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\services\booking\tours\BookingTourService;
use yii\console\Controller;

class BookingController extends Controller
{


    private $tours;

    public function __construct(
        $id,
        $module,
        BookingTourRepository $tours,
 //       BookingStayRepository $stays,
 //       BookingCarRepository $cars,

        $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->tours = $tours;
    }

    public function actionCancel()
    {
        /** @var BookingTour[] $bookings */
        $tours = $this->tours->getNotPay(1);
        foreach ($tours as $tour) {
            $tour->cancel();
            $this->tours->save($tour);
        }

    }
}