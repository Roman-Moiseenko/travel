<?php


namespace admin\controllers\car;

use booking\entities\booking\cars\Car;
use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\cars\CostCalendarRepository;
use booking\services\booking\cars\CarService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CalendarController extends Controller
{
    public $layout = 'main-cars';
    private $service;
    private $calendar;
    /**
     * @var CarRepository
     */
    private $cars;


    public function __construct(
        $id,
        $module,
        CarService $service,
        CarRepository $cars,
        CostCalendarRepository $calendar,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendar = $calendar;
        $this->cars = $cars;
    }


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $car = $this->findModel($id);
        if ($car->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного Авто');
        }
        return $this->render('index', [
            'car' => $car,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /** AJAX Запросы     */
    public function actionGetcalendar()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            if (isset($params['current_month'])) {
                $month = date('m');
                $year = date('Y');
                $day = date('d');
            } else {
                $month = $params['month'];
                $year = $params['year'];
                $day = 1;
            }
            return json_encode($this->calendar->getCalendarForDatePickerBackend($params['car_id']));
            //return json_encode($this->calendar->getCalendarForDatePicker($params['car_id'], $month, $year, $day));
        }
    }

    public function actionGetday()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['car_id']);
        }
    }

    public function actionSetday()
    {
        if (\Yii::$app->request->isAjax) {
            $errors = [];
            $params = \Yii::$app->request->bodyParams;
            //Год, Месяц, День, Время, Цена.Взр, Цена.Дет, Цена.Льгот, Кол-воБилетов
            $car = $this->findModel($params['car_id']);
            $car_at = strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00');

            try {
                $this->service->clearCostCalendar($car->id, $car_at); //Очищаем тек.день
                $test = $this->service->addCostCalendar(
                    $car->id,
                    $car_at,
                    $params['_count'],
                    $params['_cost']
                );

               $errors['new_car'] = $test;

            } catch (\DomainException $e) {
                return $e->getMessage();
            }

            //return $calendar->time_at;
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['car_id'], $errors);
        }
    }

    public function actionCopyday()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $car = $this->findModel($params['car_id']);
            try {
                $car->copyCostCalendar(
                    strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00'),
                    strtotime($params['copy_day'] . '-' . $params['copy_month'] . '-' . $params['copy_year'] . ' 00:00:00')
                );
                $this->cars->save($car);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
            return json_encode($this->calendar->getCalendarForDatePickerBackend($params['car_id']));
        }
    }

    public function actionCopyweek()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            if (isset($params['current_month'])) {
                $month = date('m');
                $year = date('Y');
                $day = date('d');
            } else {
                $month = $params['month'];
                $year = $params['year'];
                $day = $params['day'];
            }
            $car = $this->findModel($params['car_id']);
            $array_days = $this->getWeekDays(json_decode($params['json'], true), strtotime($day . '-' . $month . '-' . $year . ' 00:00:00'));
            foreach ($array_days as $new_day) {
                try {
                    $car->clearCostCalendar($new_day);
                    $this->cars->save($car);
                    $car->copyCostCalendar(
                        $new_day,
                        strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00'),
                    );
                    $this->cars->save($car);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }
            return json_encode($this->calendar->getCalendarForDatePickerBackend($params['car_id']));
        }
    }

    public function actionDelday()
    {
        if (\Yii::$app->request->isAjax) {
            $errors = null;
            $params = \Yii::$app->request->bodyParams;
            $car = $this->findModel($params['car_id']);
            $result = $car->removeCostCalendar($params['calendar_id']);
            $this->cars->save($car);
            if ($result == false) $errors['del-day'] = 'Нельзя удалить авто с бронированием';
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['car_id'], $errors);
        }
    }


    private function getInfoDay($Y, $M, $D, $id, $errors = [])
    {
        $this->layout = 'main_ajax';
        //Получаем данные
        $car = $this->findModel($id);
        $calendar = $this->calendar->getDay($id, strtotime($D . '-' . $M . '-' . $Y . ' 00:00:00'));
        //Отображаем, если есть
        $_list = $this->render('_list_cars', [
            'D' => $D, 'M' => $M, 'Y' => $Y,
            'costCalendar' => $calendar,
            'errors' => $errors,
            'clear' => !empty($calendar),
            'car' => $car,
        ]);
        //$_new = $this->render('_new_car', ['car' => $car, 'errors' => $errors]);
        $copy_week_times = empty($calendar) ? '' : $this->render('_copy_week_times');
        return json_encode([
            '_list' => $_list,
            //'_new' => $_new,
            'copy_week_times' => $copy_week_times,
            'full_array_cars' => $this->calendar->getCalendarForDatePickerBackend($id),
        ]);
    }

    private function getWeekDays($weeks, $begin)
    {
        $result = [];
        //$begin = strtotime(date('d-m-Y', time()) . ' 00:00:00');
        $end = strtotime($weeks[0]);
        $count_days = intdiv($end - $begin, 3600 * 24);
        for ($i = 1; $i <= $count_days; $i++) {
            $day = $begin + $i * 24 * 3600;
            if ($weeks[date('N', $day)]) $result[] = $day;
        }
        return $result;
    }
}