<?php


namespace frontend\controllers\tours;


use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\booking\tours\ToursRepository;
use booking\services\booking\tours\ToursService;
use yii\web\Controller;

class BookingController  extends Controller
{
    public $layout='main_ajax';
    /**
     * @var ToursService
     */
    private $service;
    /**
     * @var ToursRepository
     */
    private $tours;
    /**
     * @var CostCalendarRepository
     */
    private $calendar;

    public function __construct($id,
                                $module,
                                ToursService $service,
                                ToursRepository $tours,
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
                $day = date('d');
            } else {
                $month = $params['month'];
                $year = $params['year'];
                $day = 1;
            }
            return json_encode($this->calendar->getCalendarForDatePicker($params['tour_id'], $month, $year, $day));
        }
    }

    public function actionGetday()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['tour_id']);
        }
    }

    private function getInfoDay($year, $month, $day, $tour_id)
    {
        $day_tours = $this->calendar->getDay($tour_id, strtotime($day . '-' . $month . '-' . $year . ' 00:00:00'));

        return $this->render('_list-tours', [
            'temp' => ' День ' . $day . '. Кол-во туров ' . count($day_tours),
        ]);
        //'<h1>' . count($day_tours) . '</h1>';

    }
}