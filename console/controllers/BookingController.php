<?php


namespace console\controllers;


use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\tours\BookingTour;
use booking\repositories\booking\BookingRepository;
use booking\repositories\booking\cars\BookingCarRepository;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\services\booking\tours\BookingTourService;
use yii\console\Controller;

class BookingController extends Controller
{


    private $tours;
    /**
     * @var BookingCarRepository
     */
    private $cars;

    public function __construct(
        $id,
        $module,
        BookingTourRepository $tours,
 //       BookingStayRepository $stays,
        BookingCarRepository $cars,

        $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->tours = $tours;
        $this->cars = $cars;
    }

    public function actionCancel()
    {
        echo 'НАЧАЛО';
        /** @var BookingTour[] $tours */
        $tours = $this->tours->getNotPay(1);
        echo 'Нашлось ' . count($tours);
        foreach ($tours as $tour) {
            $tour->cancel();
            echo 'ID = ' . $tour->id;
            $this->tours->save($tour);
        }
        /** @var BookingCar[] $cars */
        $cars = $this->cars->getNotPay(1);
        echo 'Нашлось ' . count($cars);
        foreach ($cars as $car) {
            $car->cancel();
            echo 'ID = ' . $car->id;
            $this->cars->save($car);
        }
        echo 'КОНЕЦ';
        //TODO Заглушка stays, funs


    }
}