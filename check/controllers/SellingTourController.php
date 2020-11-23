<?php


namespace check\controllers;


use booking\entities\booking\tours\Tour;
use booking\entities\check\BookingObject;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\booking\tours\SellingTourRepository;
use booking\services\booking\tours\SellingTourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SellingTourController extends Controller
{
    public $layout = 'main-selling';
    /**
     * @var SellingTourService
     */
    private $service;
    /**
     * @var CostCalendarRepository
     */
    private $calendars;
    /**
     * @var SellingTourRepository
     */
    private $sellingTours;

    public function __construct(
        $id,
        $module,
        SellingTourService $service,
        CostCalendarRepository $calendars,
        SellingTourRepository $sellingTours,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendars = $calendars;
        $this->sellingTours = $sellingTours;
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
        $tour = $this->findModel($object->object_id);
        return $this->render('index', [
            'tour' => $tour,
            'object_id' => $id,
        ]);
    }

    public function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) return $model;
        throw new NotFoundHttpException('Тур не найден ID=' . $id);
    }

    public function actionGetTime()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            $calendars = $this->calendars->getDay($params['tour_id'], strtotime($params['date']), false);// CostCalendar::find()->andWhere(['tours_id' => $params['tour_id']])->andWhere(['tour_at' => strtotime($params['date'])])->all();
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
            $sales = $this->sellingTours->getByCalendarId($params['calendar_id']);
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
            $sales = $this->sellingTours->getByCalendarId($params['calendar_id']);
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
            $sales = $this->sellingTours->getByCalendarId($params['calendar_id']);
            return $this->render('_list_selling', [
                'sales' => $sales,
                'error' => $error,
            ]);
        }
    }
}