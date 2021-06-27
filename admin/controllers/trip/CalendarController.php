<?php


namespace admin\controllers\trip;

use booking\entities\booking\trips\Trip;
use booking\repositories\booking\trips\CostCalendarRepository;
use booking\repositories\booking\trips\TripRepository;

use booking\services\booking\trips\TripService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CalendarController extends Controller
{
    public $layout = 'main-trips';
    /**
     * @var TripService
     */
    private $service;
    /**
     * @var TripRepository
     */
    private $trips;
    /**
     * @var CostCalendarRepository
     */
    private $calendar;

    public function __construct(
        $id,
        $module,
        TripService $service,
        TripRepository $trips,
        CostCalendarRepository $calendar,
        $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
        $this->trips = $trips;
        $this->calendar = $calendar;
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
        $trip = $this->findModel($id);
        if ($trip->filling) $this->service->next_filling($trip);
        if ($trip->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного Тура');
        }
        return $this->render('index', [
            'trip' => $trip,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Trip::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /** AJAX Запросы     */
    public function actionGetcalendar()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            return json_encode($this->calendar->getCalendarForDatePickerBackend($params['stay_id']));
        }
        return 'Error!';
    }

    public function actionGetday()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['stay_id']);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return 'Error!';
    }

    public function actionSetday()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            try {

                $stay = $this->findModel($params['stay_id']);
                $stay_at = strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00');
                $cost_base = $params['cost_base'];
                $guest_base = $params['guest_base'];
                $cost_add = $params['cost_add'];

                $this->service->clearCostCalendar($stay->id, $stay_at); //Очищаем тек.день
                $this->service->addCostCalendar($stay->id, $stay_at, $cost_base, $guest_base, $cost_add);
                return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['stay_id']);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return 'Error!';
    }

    public function actionCopyweek()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $month = $params['month'];
            $year = $params['year'];
            $day = $params['day'];
            try {

                $stay = $this->findModel($params['stay_id']);
                $stay_at = strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00');
                $array_days = $this->getWeekDays(json_decode($params['json'], true), strtotime($day . '-' . $month . '-' . $year . ' 00:00:00'));

                foreach ($array_days as $stay_at_new) {
                    $this->service->clearCostCalendar($stay->id, $stay_at_new);
                    $this->service->copyCostCalendar($stay->id, $stay_at_new, $stay_at);
                }

            } catch (\Throwable $e) {
                return $e->getMessage();
            }

            return json_encode($this->calendar->getCalendarForDatePickerBackend($stay->id));
        }
    }

    public function actionDelday()
    {
        if (\Yii::$app->request->isAjax) {
            $errors = null;
            $params = \Yii::$app->request->bodyParams;
            try {
                $stay = $this->findModel($params['stay_id']);
                $stay_at = strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00');
                $this->service->clearCostCalendar($stay->id, $stay_at);
                return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['stay_id']);
            } catch (\DomainException $e) {
                return $e->getMessage();
            }
        }
    }

    private function getInfoDay($Y, $M, $D, $id, $errors = [])
    {
        $this->layout = 'main_ajax';
        //Получаем данные
        $stay = $this->findModel($id);
        //Получаем данные по календарю
        $calendar = $this->calendar->getDay($id, strtotime($D . '-' . $M . '-' . $Y . ' 00:00:00'), false);
        // $button_times = $this->render('_button_times', ['clear' => count($calendars) != 0]);
        $copy_week_times = ($calendar == null) ? '' : $this->render('_copy_week_times');
        $_list = $this->render('_list_stays', [
            'D' => $D, 'M' => $M, 'Y' => $Y,
            'costCalendar' => $calendar,
            'errors' => $errors,
            'clear' => !empty($calendar),
            'stay' => $stay,
        ]);
        return json_encode([
            '_list' => $_list,
            'copy_week_times' => $copy_week_times,
            'full_array_stays' => $this->calendar->getCalendarForDatePickerBackend($id)
        ]);
    }

    private function getWeekDays($weeks, $begin)
    {
        $result = [];
        $end = strtotime($weeks[0]);
        $count_days = intdiv($end - $begin, 3600 * 24);
        for ($i = 1; $i <= $count_days; $i++) {
            $day = $begin + $i * 24 * 3600;
            if ($weeks[date('N', $day)]) $result[] = $day;
        }
        return $result;
    }
}