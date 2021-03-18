<?php


namespace frontend\controllers\cars;

use booking\entities\booking\cars\CostCalendar;
use booking\helpers\CurrencyHelper;
use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\cars\CostCalendarRepository;
use booking\services\booking\cars\CarService;
use yii\web\Controller;

class BookingController extends Controller
{
    public $layout = 'main_ajax';
    /**
     * @var CarService
     */
    private $service;
    /**
     * @var CarRepository
     */
    private $cars;
    /**
     * @var CostCalendarRepository
     */
    private $calendar;

    public function __construct(
        $id,
        $module,
        CarService $service,
        CarRepository $cars,
        CostCalendarRepository $calendar,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->cars = $cars;
        $this->calendar = $calendar;
    }

    public function actionGetCalendar()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            if (isset($params['date_from'])) {
                $date_from = strtotime($params['date_from']);
            } else {
                $date_from = null;
            }
            if (isset($params['date_to'])) {
                $date_to = strtotime($params['date_to']);
            } else {
                $date_to = null;
            }
            return json_encode($this->calendar->getCalendarForDatePickerAll($params['car_id'], $date_from, $date_to));
        }
        return $this->goHome();
    }

    public function actionGetRentCar()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $date_from = strtotime($params['date_from']);
            $date_to = strtotime($params['date_to']);
            $car_id = $params['car_id'];
            $rent_car = $this->calendar->getRentCar($car_id, $date_from, $date_to);
            return $this->render('_rent-car', [
                'rent_car' => $rent_car,
            ]);
        }
        return $this->goHome();
    }

    public function actionGetAmount()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $car = $this->cars->get((int)$params['car_id']);
            $count = (int)$params['count_car'];
            $date_from = strtotime($params['date_from']);
            $date_to = strtotime($params['date_to']);
            $calendars = CostCalendar::find()
                ->andWhere(['car_id' => (int)$params['car_id']])
                ->andWhere(['>=', 'car_at', $date_from]) //На следующий день
                ->andWhere(['<=', 'car_at', $date_to]) //На следующий день
                ->orderBy(['car_at' => SORT_ASC])
                ->all();

            $result = 0;
            foreach ($calendars as $calendar) {
                $result += $calendar->cost;
            }

            if ($car->discount_of_days && count($calendars) > 3) {
                $result = $result * (1 - $car->discount_of_days /100);
            }
            $result *= $count;
            return $this->render('_amount', [
                'full_cost' => $result,
                'prepay' => $result * $calendars[0]->car->prepay / 100,
                'percent' => $calendars[0]->car->prepay
            ]);
        }
        return $this->goHome();
    }
}