<?php


namespace admin\controllers\tours;


use booking\entities\booking\tours\Tours;
use booking\forms\booking\tours\ToursFinanceForm;
use booking\repositories\booking\tours\CostCalendarRepository;
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

    public function __construct(
        $id,
        $module,
        ToursService $service,
        CostCalendarRepository $calendar,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendar = $calendar;
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
            //$result[] = $params['month'];
            //$result[] = $params['year'];

            $month[6] = ['count' => 4];
            $month[3] = ['count' => 1];
            $month[13] = ['count' => 2];
            $month[10] = ['count' => 2];

            $month2[22] = ['count' => 4];
            $month2[17] = ['count' => 5];
            $month2[27] = ['count' => 1];
            $month2[24] = ['count' => 1];
            $month3[27] = ['count' => 1];
            $month3[24] = ['count' => 1];
            $result[2020][8] = $month;
            $result[2020][9] = $month2;
            $result[2021][1] = $month3;

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
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['tour_id']);

        }
    }

    public function actionDelday()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            // TODO Удаляем
            return $this->getInfoDay($params['year'], $params['month'], $params['day'], $params['tour_id']);

        }
    }

    private function getInfoDay($Y, $M, $D, $id)
    {
        //Получаем данные

        $day_tours = $this->calendar->getDay($id, strtotime($D . '-' . $M . '-' . $Y . ' 00:00:00'));

        //Отображаем, если есть
        $listTours = <<<HTML
<div class="row">
    <span style="font-size: larger; font-weight: bold">На $D число</span> 
</div>
<div class="row">
    <span style="font-size: larger"><i class="far fa-clock"></i>12:00 <a href="#"><i class="far fa-trash-alt"></i></a></span> 
</div>
<div class="row">
    &nbsp;&nbsp;&nbsp;20 билетов. Цена: 5000/3500/-- 
</div>
HTML;

        $newTours = <<<HTML
<div id="data-day" data-d="$D" data-m="$M" data-y="$Y"></div>
                <div class="row">
                
                    <div class="col-2">
                        <div class="form-group">
                            <label>Начало</label>
                            <input class="form-control" name="_time" type="time" width="100px" value="00:00" required>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label>Билеты</label>
                            <input class="form-control" name="_tickets" type="number" width="100px" required>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label>Цена за взрослый</label>
                            <input class="form-control" name="_adult" type="number" width="100px" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Цена за детский</label>
                            <input class="form-control" name="_child" type="number" width="100px">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Цена за льготный</label>
                            <input class="form-control" name="_preference" type="number" width="100px">
                        </div>
                    </div>
                    <div class="col-1">
                        <a href="#" class="btn btn-success" id="send-new-tour">Добавить</a>
                    </div>
                </div>
HTML;
        $result = ['_list' => $listTours, '_new' => $newTours];
        return json_encode($result);
    }
}