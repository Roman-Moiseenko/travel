<?php


namespace office\controllers;


use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use booking\entities\Rbac;
use booking\services\booking\stays\StayService;
use booking\services\booking\tours\TourService;
use office\forms\StaysSearch;
use office\forms\ToursSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class StaysController extends Controller
{

    /**
     * @var StayService
     */
    private $service;

    public function __construct($id, $module, StayService $service, $config = [])
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
        $searchModel = new StaysSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $stay = $this->find($id);

        return $this->render('view', [
            'stay' => $stay,
        ]);
    }


    public function actionActive($id)
    {
        $stay = $this->find($id);
        $this->service->activate($stay->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionLock($id)
    {
        $stay = $this->find($id);
        $this->service->lock($stay->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnlock($id)
    {
        $stay = $this->find($id);
        $this->service->unlock($stay->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }
    public function find($id)
    {
        if (!$stay = Stay::findOne($id))
            throw new \DomainException('Жилище не найдено');
        return $stay;
    }
}