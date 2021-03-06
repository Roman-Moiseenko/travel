<?php


namespace check\controllers;


use booking\entities\booking\funs\Fun;
use booking\entities\check\BookingObject;
use booking\repositories\booking\funs\SellingFunRepository;
use booking\repositories\booking\funs\CostCalendarRepository;
use booking\services\booking\funs\SellingFunService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SellingFunController extends Controller
{
    public $layout = 'main-selling';
    /**
     * @var SellingFunService
     */
    private $service;
    /**
     * @var CostCalendarRepository
     */
    private $calendars;
    /**
     * @var SellingFunRepository
     */
    private $sellingFuns;

    public function __construct(
        $id,
        $module,
        SellingFunService $service,
        CostCalendarRepository $calendars,
        SellingFunRepository $sellingFuns,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendars = $calendars;
        $this->sellingFuns = $sellingFuns;
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
        $object = BookingObject::findOne($id);
        $fun = $this->findModel($object->object_id);
        return $this->render('index', [
            'fun' => $fun,
            'object_id' => $id,
        ]);
    }

    public function findModel($id)
    {
        if (($model = Fun::findOne($id)) !== null) return $model;
        throw new NotFoundHttpException('Мероприятие не найдено ID=' . $id);
    }

    public function actionGetTime()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $calendars = $this->calendars->getDay($params['fun_id'], strtotime($params['date']), false);
            return $this->render('_list_times', [
                'calendars' => $calendars,
            ]);
        }
    }

    public function actionGetSelling()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $sales = $this->sellingFuns->getByCalendarId($params['calendar_id']);
            return $this->render('_list_selling', [
                'sales' => $sales,
                'error' => '',
            ]);
        }
    }

    public function actionAddSelling()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $error = '';
            if (!$this->service->create($params['calendar_id'], $params['count'])) $error = 'Недостаточно свободных билетов';
            $sales = $this->sellingFuns->getByCalendarId($params['calendar_id']);
            return $this->render('_list_selling', [
                'sales' => $sales,
                'error' => $error,
            ]);
        }
    }

    public function actionRemoveSelling()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $error = '';
            if (!$this->service->remove($params['selling_id'])) $error = 'Ошибка удаление';
            $sales = $this->sellingFuns->getByCalendarId($params['calendar_id']);
            return $this->render('_list_selling', [
                'sales' => $sales,
                'error' => $error,
            ]);
        }
    }
}