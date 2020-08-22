<?php


namespace admin\controllers\tours;


use booking\entities\booking\tours\Tour;
use booking\helpers\CalendarHelper;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
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
        $tours = $this->findModel($id);
        if ($tours->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного тура');
        }
        return $this->render('index', [
            'tours' => $tours,
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

    public function actionSetday()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            //Год, Месяц, День, Время, Цена.Взр, Цена.Дет, Цена.Льгот, Кол-воБилетов
            $tours = $this->findModel($params['tour_id']);
            try {

                $calendar = $tours->addCostCalendar(
                    strtotime($params['day'] . '-' . $params['month'] . '-' . $params['year'] . ' 00:00:00'),
                    $params['_time'],
                    $params['_tickets'],
                    $params['_adult'],
                    $params['_child'],
                    $params['_preference']
                );
                $this->tours->save($tours);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }

            //return $calendar->time_at;
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['tour_id']);
        }
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
            return json_encode($this->calendar->getCalendarForDatePicker($params['tour_id'], $params['month'], $params['year']));
        }
    }

    public function actionDelday()
    {
        if (\Yii::$app->request->isAjax) {
            $errors = null;
            $params = \Yii::$app->request->bodyParams;
            $tours = $this->findModel($params['tour_id']);
            $result = $tours->removeCostCalendar($params['calendar_id']);
            $this->tours->save($tours);
            if (!$result) $errors['del-day'] = 'Нельзя удалить непустой тур';
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['tour_id'], $errors);
        }
    }


    private function getInfoDay($Y, $M, $D, $id, $errors = [])
    {
        //Получаем данные
        $tours = $this->findModel($id);
        $day_tours = $this->calendar->getDay($id, strtotime($D . '-' . $M . '-' . $Y . ' 00:00:00'));
        //Отображаем, если есть
        $listTours = <<<HTML
                <div id="data-day" data-d="$D" data-m="$M" data-y="$Y"></div>
<div class="row">
    <span style="font-size: larger; font-weight: bold">На $D число</span> 
</div>
HTML;
        if (isset($errors) && isset($errors['del-day'])) {
            $error_del_day = $errors['del-day'];
            $listTours .= <<<HTML
<div class="row">
    <span style="font-size: larger; font-weight: bold; color: #c12e2a">$error_del_day</span> 
</div>
HTML;
        }
        foreach ($day_tours as $costCalendar) {
            $id_calendar = $costCalendar->id;
            $time = $costCalendar->time_at;
            $tickets = $costCalendar->tickets;
            $adult = $costCalendar->cost->adult;
            $child = $costCalendar->cost->child ?? '--';
            $preference = $costCalendar->cost->preference ?? '--';

            $listTours .= <<<HTML

<div class="row">
    <span style="font-size: larger"><i class="far fa-clock"></i>$time <a href="#" class="del-day" data-id="$id_calendar"><i class="far fa-trash-alt"></i></a></span> 
</div>
<div class="row">
    &nbsp;&nbsp;&nbsp;$tickets билетов. Цена: $adult/$child/$preference 
</div>
HTML;
        }
        if ($day_tours != null) {
            $listTours .= <<<HTML
<div class="row">
<label class="container">
    <input type="checkbox" id="data-day-copy"><span>Копировать на другие дни</span>
    </label>
    <i>Поставьте флажок, и выбирайте дни. После снимите флажок и выберите любой день</i>
</div>
HTML;
        } else {
            $listTours .= <<<HTML
<div class="row">
    <span style="font-size: larger; font-weight: bold">туры не заданы</span> 
</div>
HTML;
        }

        $adult = $tours->baseCost->adult;
        $newTours = <<<HTML

                <div class="row">
                    <div class="col-2">
                        <div class="form-group">
                            <label>Начало</label>
                            <input class="form-control" id="_time" type="time" width="100px" value="00:00" required>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label>Билеты</label>
                            <input class="form-control" id="_tickets" type="number" min="1" value="1" width="100px" required>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label>Цена за взрослый билет</label>
                            <input class="form-control" id="_adult" type="number" value="$adult" min="0" step="50" width="100px" required>
                        </div>
                    </div>
HTML;
        if ($tours->baseCost->child != null) {
            $child = $tours->baseCost->child;
            $newTours .= <<<HTML
                     <div class="col-3">
                        <div class="form-group">
                            <label>Цена за детский билет</label>
                            <input class="form-control" id="_child" type="number" value="$child" min="0" step="50" width="100px">
                        </div>
                    </div>
HTML;
        }
        if ($tours->baseCost->preference != null) {
            $preference = $tours->baseCost->preference;
            $newTours .= <<<HTML
                    <div class="col-3">
                        <div class="form-group">
                            <label>Цена за льготный билет</label>
                            <input class="form-control" id="_preference" type="number" value="$preference" min="0" step="50" width="100px">
                        </div>
                    </div>
                    HTML;
        }
        $newTours .= <<<HTML
</div>
<div class="row">
                    <div class="col-1">
                        <a href="#" class="btn btn-success" id="send-new-tour">Добавить</a>
                    </div>
                </div>
HTML;
        $result = ['_list' => $listTours, '_new' => $newTours, 'full_array_tours' => $this->calendar->getCalendarForDatePicker($id, (int)$M, (int)$Y)];
        return json_encode($result);
    }
}