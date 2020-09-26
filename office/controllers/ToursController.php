<?php


namespace office\controllers;


use booking\entities\booking\tours\Tour;
use booking\entities\Rbac;
use booking\services\booking\tours\TourService;
use office\forms\ToursSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ToursController extends Controller
{

    /**
     * @var TourService
     */
    private $service;

    public function __construct($id, $module, TourService $service, $config = [])
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
        $searchModel = new ToursSearch();
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
            'tour' => $tour,
        ]);
    }


    public function actionActive($id)
    {
        $tour = $this->find($id);
        $this->service->activate($tour->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionLock($id)
    {
        $tour = $this->find($id);
        $this->service->lock($tour->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnlock($id)
    {
        $tour = $this->find($id);
        $this->service->unlock($tour->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }
    public function find($id)
    {
        if (!$tour = Tour::findOne($id))
            throw new \DomainException('Тур не найден');
        return $tour;
    }
}