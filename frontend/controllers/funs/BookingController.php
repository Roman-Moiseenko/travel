<?php


namespace frontend\controllers\funs;

use booking\entities\booking\funs\CostCalendar;
use booking\entities\booking\funs\Fun;
use booking\helpers\CurrencyHelper;
use booking\repositories\booking\funs\CostCalendarRepository;
use booking\repositories\booking\funs\FunRepository;
use booking\services\booking\funs\FunService;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class BookingController extends Controller
{
    public $layout = 'main_ajax';
    /**
     * @var FunService
     */
    private $service;
    /**
     * @var FunRepository
     */
    private $funs;
    /**
     * @var CostCalendarRepository
     */
    private $calendar;

    public function __construct(
        $id,
        $module,
        FunService $service,
        FunRepository $funs,
        CostCalendarRepository $calendar,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->funs = $funs;
        $this->calendar = $calendar;
    }

    public function actionGetCalendar()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            //$date = isset($params['date']) ? strtotime($params['date']) : null;
            return json_encode($this->calendar->getCalendarForDatePickerAll($params['fun_id']));
        }
        return $this->goHome();
    }

    public function actionGetTimes()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $fun = Fun::findOne($params['fun_id']);
            $fun_at = strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00');
            if (Fun::isClearTimes($fun->type_time)) {
                $current = $this->calendar->getCurrentForClearTime($fun->id, $fun_at);
                //$current = $this->calendar->getCurrentByTime($fun->id, $time_at);
                return $this->render('_tickets', [
                    'current' => $current
                ]);
            }

            if ($fun->isMulti()) {
                $times = $this->calendar->getTimes($fun->id, $fun_at, true);
                $_calendars = [];
                foreach ($times as $calendar) {
                    $_calendars[] = ['id' => $calendar->id, 'time' => $calendar->time_at, 'count' => $calendar->free()];
                }
                return $this->render('_times_multi', [
                    'calendar_json' => str_replace('"', "'", json_encode($_calendars))
                ]);

            } else {
                $times = $this->calendar->getTimes($fun->id, $fun_at);
                return $this->render('_times', [
                    'times' => $times,
                ]);
            }
        }
        return $this->goHome();
    }

    public function actionGetTickets()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $current = $this->calendar->get($params['calendar_id']);
            return $this->render('_tickets', [
                'current' => $current
            ]);
        }
        return $this->goHome();
    }

    public function actionGetAmount()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $calendar_ids = $params['calendar_id'];
            //return var_dump($calendar_ids);

            $count_adult = $params['count_adult'];
            $count_child = $params['count_child'];
            $count_preference = $params['count_preference'];
            $result = 0;
            foreach ($calendar_ids as $calendar_id) {
                $calendar = $this->calendar->get($calendar_id);
                $result += $count_adult * $calendar->cost->adult + $count_child * $calendar->cost->child + $count_preference * $calendar->cost->preference;
            }
            return '<span class="badge badge-success" style="font-size: 18px; font-weight: 600;"> ' .
                ($result !== 0 ? CurrencyHelper::get($result) : ' - ') . '</span>';
        }
        return $this->goHome();
    }
}