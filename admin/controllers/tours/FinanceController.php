<?php


namespace admin\controllers\tours;


use booking\entities\booking\tours\Tours;
use booking\forms\booking\tours\ToursFinanceForm;
use booking\services\booking\tours\ToursService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\NotFoundHttpException;

class FinanceController extends Controller
{
    public  $layout = 'main-tours';
    private $service;

    public function __construct($id, $module, ToursService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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
        $multi = boolval(\Yii::$app->request->queryParams['multi']) ?? false;
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
}