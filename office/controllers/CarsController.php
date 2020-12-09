<?php


namespace office\controllers;


use booking\entities\booking\cars\Car;
use booking\entities\Rbac;
use booking\services\booking\cars\CarService;
use office\forms\CarsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CarsController extends Controller
{
    private $service;

    public function __construct($id, $module, CarService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_MANAGER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CarsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $car = $this->find($id);

        return $this->render('view', [
            'car' => $car,
        ]);
    }


    public function actionActive($id)
    {
        $car = $this->find($id);
        $this->service->activate($car->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionLock($id)
    {
        $car = $this->find($id);
        $this->service->lock($car->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnlock($id)
    {
        $car = $this->find($id);
        $this->service->unlock($car->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }
    public function find($id)
    {
        if (!$car = Car::findOne($id))
            throw new \DomainException('Авто не найдено');
        return $car;
    }
}