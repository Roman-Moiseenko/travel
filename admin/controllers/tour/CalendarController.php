<?php


namespace admin\controllers\tour;


use booking\entities\booking\tours\Tour;
use booking\helpers\CalendarHelper;
use booking\helpers\scr;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CalendarController extends Controller
{
    public $layout = 'main-tours';
    private $service;
    /**
     * @var CostCalendarRepository
     */
    private $calendar;
    /**
     * @var TourRepository
     */
    private $tours;

    public function __construct(
        $id,
        $module,
        TourService $service,
        TourRepository $tours,
        CostCalendarRepository $calendar,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendar = $calendar;
        $this->tours = $tours;
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
        $tour = $this->findModel($id);
        if ($tour->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного тура');
        }
        return $this->render('index', [
            'tour' => $tour,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) {
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
            return json_encode($this->calendar->getCalendarForDatePickerBackend($params['tour_id']));
        }
        return $this->redirect(Url::to(['']));
    }

    public function actionGetday()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['tour_id']);
        }
        return $this->goHome();
    }

    public function actionSetday()
    {
        if (\Yii::$app->request->isAjax) {
            $errors = [];
            $params = \Yii::$app->request->bodyParams;
            //Год, Месяц, День, Время, Цена.Взр, Цена.Дет, Цена.Льгот, Кол-воБилетов
            $tour = $this->findModel($params['tour_id']);
            try {
                $test = $this->service->addCostCalendar(
                    $tour->id,
                    strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00'),
                    $params['_time'],
                    $params['_tickets'],
                    $params['_adult'],
                    $params['_child'],
                    $params['_preference']
                );
               $errors['new_tour'] = $test;
            } catch (\DomainException $e) {
                return $e->getMessage();
            }
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['tour_id'], $errors);
        }
        return $this->goHome();
    }

    public function actionCopyday()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $tours = $this->findModel($params['tour_id']);
            try {
                $tours->copyCostCalendar(
                    strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00'),
                    strtotime($params['copy_day'] . '-' . $params['copy_month'] . '-' . $params['copy_year'] . ' 00:00:00')
                );
                $this->tours->save($tours);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
            return json_encode($this->calendar->getCalendarForDatePickerBackend($params['tour_id']));
        }
        return $this->goHome();
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
            $tours = $this->findModel($params['tour_id']);
            $array_days = $this->getWeekDays(json_decode($params['json'], true), strtotime($day . '-' . $month . '-' . $year . ' 00:00:00'));
            foreach ($array_days as $new_day) {
                try {
                    $tours->clearCostCalendar($new_day);
                    $this->tours->save($tours);
                    $tours->copyCostCalendar(
                        $new_day,
                        strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00'),
                    );
                    $this->tours->save($tours);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }
            return json_encode($this->calendar->getCalendarForDatePickerBackend($params['tour_id']));
        }
        return $this->goHome();
    }

    public function actionDelday()
    {
        if (\Yii::$app->request->isAjax) {
            $errors = null;
            $params = \Yii::$app->request->bodyParams;
            $tours = $this->findModel($params['tour_id']);
            $result = $tours->removeCostCalendar($params['calendar_id']);
            $this->tours->save($tours);
            if ($result == false) $errors['del-day'] = 'Нельзя удалить тур с бронированием';
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['tour_id'], $errors);
        }
        return $this->goHome();
    }


    private function getInfoDay($Y, $M, $D, $id, $errors = [])
    {
        $this->layout = 'main_ajax';
        //Получаем данные
        $tours = $this->findModel($id);
        $day_tours = $this->calendar->getDay($id, strtotime($D . '-' . $M . '-' . $Y . ' 00:00:00'), false);
        //Отображаем, если есть
        $_list = $this->render('_list_tours', [
            'D' => $D, 'M' => $M, 'Y' => $Y,
            'day_tours' => $day_tours,
            'errors' => $errors,
        ]);
        $_new = $this->render('_new_tour', ['tour' => $tours, 'errors' => $errors]);
        $result = ['_list' => $_list, '_new' => $_new, 'full_array_tours' => $this->calendar->getCalendarForDatePickerBackend($id)];
        return json_encode($result);
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