<?php


namespace admin\controllers\tours;


use booking\entities\booking\tours\Tours;
use booking\forms\booking\tours\ToursFinanceForm;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\booking\tours\ToursRepository;
use booking\services\booking\tours\ToursService;
use Codeception\PHPUnit\ResultPrinter\HTML;
use DateTime;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\NotFoundHttpException;

class FinanceController extends Controller
{
    public $layout = 'main-tours';
    private $service;
    /**
     * @var CostCalendarRepository
     */
    private $calendar;
    /**
     * @var ToursRepository
     */
    private $tours;

    public function __construct(
        $id,
        $module,
        ToursService $service,
        ToursRepository $tours,
        CostCalendarRepository $calendar,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendar = $calendar;
        $this->tours = $tours;
    }

    /*   public function actions() {
           return [
               'calendar' => [
                   'class' => 'understeam\calendar\CalendarAction',
                   'calendar' => 'calendar',           // ID компонента календаря (да, можно подключать несколько)
                   'usePjax' => true,                  // Использовать ли pjax для ajax загрузки страниц
                   'widgetOptions' => [                // Опции виджета (см. CalendarWidget)
                       'clientOptions' => [            // Опции JS плагина виджета
                           'onClick' => new JsExpression('showPopup'),   // JS функция, которая будет выполнена при клике на доступное время
                           'onFutureClick' => new JsExpression('buyPlan'),
                           'onPastClick' => new JsExpression('showError'),
                           // Все эти функции принимают 2 параметра: date и time
                           // Для тестирования можно использовать следующий код:
                           // 'onClick' => new JsExpression("function(d,t){alert([d,t].join(' '))}")
                       ],
                   ],
               ],
           ];
       }
   */
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
        return $this->render('view', [
            'tours' => $tours,
        ]);
    }

    public function actionUpdate($id)
    {
        $tours = $this->findModel($id);
        if ($tours->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного тура');
        }
        $form = new ToursFinanceForm($tours);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setFinance($tours->id, $form);
                return $this->redirect(['/tours/finance', 'id' => $tours->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'tours' => $tours,
            'model' => $form,
        ]);
    }

    public function actionCalendar($id)
    {
        $tours = $this->findModel($id);
        if ($tours->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного тура');
        }
        // print_r(\Yii::$app->request->queryParams); exit();
        if (!isset(\Yii::$app->request->queryParams['multi'])) {
            $multi = false;
        } else {
            $multi = boolval(\Yii::$app->request->queryParams['multi']);
        }
        //var_dump($multi); exit();
        return $this->render('calendar', [
            'tours' => $tours,
            'multi' => $multi,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Tours::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetcalendar()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $calendars = $this->calendar->getActual($params['tour_id']);
            $result = [];
            foreach ($calendars as $calendar) {
                $result[date('Y', $calendar->time_at)][date('m', $calendar->time_at)][date('d',$calendar->time_at)] = $calendar->tickets;
            }
            return json_encode($result);
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
            // TODO Устанавливаем новые данные
            $tours = $this->findModel($params['tour_id']);
            $tours->addCostCalendar(
                strtotime($params['day'] . '-' . $params['month'] . '-'. $params['year'] . ' 00:00:00'),
                $params['_time'],
                $params['_adult'],
                $params['_child'],
                $params['_preference'],
                $params['_tickets']
            );
            $this->tours->save($tours);
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['tour_id']);

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
            if (!$result) $errors['del-day'] = 'Нельзя удалить не пустой тур';
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['tour_id'], $errors);
        }
    }

    private function getInfoDay($Y, $M, $D, $id, $errors = [])
    {
        //Получаем данные
        $tours = $this->findModel($id);
        $day_tours = $this->calendar->getDay($id, strtotime($D . '-' . $M . '-' . $Y . ' 00:00:00'));
        //Отображаем, если есть
        $listTours = '';
        foreach ($day_tours as $costCalendar) {
            $id_calendar = $costCalendar->id;
            $time = $costCalendar->time_at;
            $tickets = $costCalendar->tickets;
            $adult = $costCalendar->cost->adult;
            $child = $costCalendar->cost->child ?? '--';
            $preference = $costCalendar->cost->preference ?? '--';
            if (isset($errors) && isset($errors['del-day']))
                //TODO !!!!!!!!!!!!!!!!!!!;
                ;
            $listTours = <<<HTML
<div class="row">
    <span style="font-size: larger; font-weight: bold">На $D число</span> 
</div>
<div class="row">
    <span style="font-size: larger"><i class="far fa-clock"></i>$time <a href="#" class="del-day" data-id="$id_calendar"><i class="far fa-trash-alt"></i></a></span> 
</div>
<div class="row">
    &nbsp;&nbsp;&nbsp;$tickets билетов. Цена: $adult/$child/$preference 
</div>
HTML;
        }
        if ($day_tours == null){
        $listTours = <<<HTML
<div class="row">
    <span style="font-size: larger; font-weight: bold">На $D число туры не заданы</span> 
</div>
HTML;
    }

        $adult = $tours->baseCost->adult;
        $newTours = <<<HTML
                <div id="data-day" data-d="$D" data-m="$M" data-y="$Y"></div>
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
                            <input class="form-control" id="_tickets" type="number" value="1" width="100px" required>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label>Цена за взрослый билет</label>
                            <input class="form-control" id="_adult" type="number" value="$adult" width="100px" required>
                        </div>
                    </div>
HTML;
        if ($tours->baseCost->child != null) {
            $child = $tours->baseCost->child;
            $newTours .= <<<HTML
                     <div class="col-3">
                        <div class="form-group">
                            <label>Цена за детский билет</label>
                            <input class="form-control" id="_child" type="number" value="$child" width="100px">
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
                            <input class="form-control" id="_preference" type="number" value="$preference" width="100px">
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
        $result = ['_list' => $listTours, '_new' => $newTours];
        return json_encode($result);
    }
}