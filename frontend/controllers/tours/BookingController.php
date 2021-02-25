<?php


namespace frontend\controllers\tours;


use booking\entities\booking\cars\CostCalendar;
use booking\helpers\CurrencyHelper;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\services\booking\tours\TourService;
use yii\web\Controller;

class BookingController  extends Controller
{
    public $layout = 'main_ajax';
    /**
     * @var TourService
     */
    private $service;
    /**
     * @var TourRepository
     */
    private $tours;
    /**
     * @var CostCalendarRepository
     */
    private $calendar;

    public function __construct($id,
                                $module,
                                TourService $service,
                                TourRepository $tours,
                                CostCalendarRepository $calendar,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->tours = $tours;
        $this->calendar = $calendar;
    }

    public function actionGetcalendar()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            if (isset($params['current_month'])) {
                $month = date('m');
                $year = date('Y');
                $day = date('d') + 1;
            } else {
                $month = $params['month'];
                $year = $params['year'];
                $day = 1;
            }
            return json_encode($this->calendar->getCalendarForDatePicker($params['tour_id'], $month, $year, $day));
        }
        return $this->goHome();
    }

    public function actionGetday()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            return '<h1>ERRORS</h1>'; // $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['tour_id']);
        }
        return $this->goHome();
    }

    private function getInfoDay($year, $month, $day, $tour_id)
    {
        $day_tours = $this->calendar->getDay($tour_id, strtotime($day . '-' . $month . '-' . $year . ' 00:00:00'));

        return $this->render('_list-tours', [
            'day_tours' => $day_tours,
        ]);

    }

    public function actionGetlisttours()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $day_tours = $this->calendar->getDay(
                $params['tour_id'],
                strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00')
            );
            return $this->render('_list-tours', [
                'day_tours' => $day_tours,
            ]);
        }
        return $this->goHome();
    }

    public function actionGettickets()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $current = $this->calendar->get($params['calendar_id']);
            return $this->render('_tickets-tours', [
                'current' => $current,
            ]);
        }
        return $this->goHome();
    }

    public function actionGetAmount()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $calendar_id = $params['calendar_id'];
            $count_adult = $params['count_adult'];
            $count_child = $params['count_child'];
            $count_preference = $params['count_preference'];
            $calendar = $this->calendar->get($calendar_id);
            $result = $count_adult * $calendar->cost->adult + $count_child * $calendar->cost->child + $count_preference * $calendar->cost->preference;
            return '<span class="badge badge-success" style="font-size: 18px; font-weight: 600;"> ' .
                ($result !== 0 ? CurrencyHelper::get($result) : ' - ') . '</span>';
        }
        return $this->goHome();
    }
}