<?php


namespace office\controllers;


use booking\entities\booking\tours\Tour;
use booking\entities\booking\trips\Trip;
use booking\entities\Rbac;
use booking\services\booking\tours\TourService;
use booking\services\booking\trips\TripService;
use office\forms\ToursSearch;
use office\forms\TripsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class TripsController extends Controller
{

    /**
     * @var TripService
     */
    private $service;

    public function __construct($id, $module, TripService $service, $config = [])
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
        $searchModel = new TripsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $tour = $this->find($id);

        return $this->render('view', [
            'trip' => $trip,
        ]);
    }

    public function actionActive($id)
    {
        $trip = $this->find($id);
        $this->service->activate($trip->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionLock($id)
    {
        $trip = $this->find($id);
        $this->service->lock($trip->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnlock($id)
    {
        $trip = $this->find($id);
        $this->service->unlock($trip->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }
    public function find($id)
    {
        if (!$trip = Trip::findOne($id))
            throw new \DomainException('Тур не найден');
        return $trip;
    }
}