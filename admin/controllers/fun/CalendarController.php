<?php


namespace admin\controllers\fun;

use admin\widgest\calendar\SetTimesWidget;
use booking\entities\booking\funs\CostCalendar;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\funs\Times;
use booking\repositories\booking\funs\CostCalendarRepository;
use booking\repositories\booking\funs\FunRepository;
use booking\services\booking\funs\FunService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CalendarController extends Controller
{
    public $layout = 'main-funs';
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
        $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
        $this->funs = $funs;
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
        $fun = $this->findModel($id);
        if ($fun->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного Развлечения');
        }
        return $this->render('index', [
            'fun' => $fun,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Fun::findOne($id)) !== null) {
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
            return json_encode($this->calendar->getCalendarForDatePickerBackend($params['fun_id']));
        }
    }

    public function actionGetday()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['fun_id']);
        }
    }

    public function actionSetday()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;

            $fun = $this->findModel($params['fun_id']);
            $fun_at = strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00');
            try {
                $this->service->clearCostCalendar($fun->id, $fun_at); //Очищаем тек.день
                foreach ($params['times'] as $time) {
                    $time_at = $time['begin'] . (empty($params['end']) ? '' : (' - ' . $time['end']));
                    $this->service->addCostCalendar(
                        $fun->id,
                        $fun_at,
                        $time_at,
                        $time['quantity'],
                        $time['cost_adult'],
                        $time['cost_child'] ?? null,
                        $time['cost_preference'] ?? null
                    );
                }
                return '';
            } catch (\DomainException $e) {
                return $e->getMessage();
            }
        }
    }

    public function actionCopyweek()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $month = $params['month'];
            $year = $params['year'];
            $day = $params['day'];
            try {
                $fun = $this->findModel($params['fun_id']);
                $fun_at = strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00');
                $array_days = $this->getWeekDays(json_decode($params['json'], true), strtotime($day . '-' . $month . '-' . $year . ' 00:00:00'));
                foreach ($array_days as $fun_at_new) {
                    $this->service->clearCostCalendar($fun->id, $fun_at_new);
                    $this->service->copyCostCalendar($fun->id, $fun_at_new, $fun_at);
                    //$fun->copyCostCalendar($fun_at_new, $fun_at,);
                    //$this->funs->save($fun);
                }
                return '';
            } catch (\DomainException $e) {
                return $e->getMessage();
            }
        }
    }

    public function actionDelday()
    {
        if (\Yii::$app->request->isAjax) {
            $errors = null;
            $params = \Yii::$app->request->bodyParams;
            try {
                $fun = $this->findModel($params['fun_id']);
                $fun_at = strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00');
                $this->service->clearCostCalendar($fun->id, $fun_at);
                return '';
            } catch (\DomainException $e) {
                return $e->getMessage();
            }
        }
    }

    private function getInfoDay($Y, $M, $D, $id, $errors = [])
    {
        $this->layout = 'main_ajax';
        //Получаем данные
        $fun = $this->findModel($id);
        //Получаем данные по календарю
        $calendars = $this->calendar->getDay($id, strtotime($D . '-' . $M . '-' . $Y . ' 00:00:00'), false);
        //Рендерим в зависимости от типа билета календарь по дню пустой или с данными
        $set_times = SetTimesWidget::widget([
            'fun' => $fun,
            'calendars' => $calendars,
            'errors' => $errors,
            'D' => $D,
            'M' => $M,
            'Y' => $Y,
            'clear' => count($calendars) != 0
        ]);

       // $button_times = $this->render('_button_times', ['clear' => count($calendars) != 0]);
        $copy_week_times = count($calendars) == 0 ? '' : $this->render('_copy_week_times');

        return json_encode([
            'set_times' => $set_times,
            //'button_times' => $button_times,
            'copy_week_times' => $copy_week_times,
            'full_array_funs' => $this->calendar->getCalendarForDatePickerBackend($id)
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