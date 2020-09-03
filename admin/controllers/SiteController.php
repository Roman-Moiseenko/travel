<?php

namespace admin\controllers;


use admin\forms\DiscountSearch;
use admin\forms\TourSearch;
use booking\repositories\booking\DiscountRepository;
use booking\services\admin\UserManageService;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @var DiscountRepository
     */
    private $discounts;
    /**
     * @var UserManageService
     */
    private $service;

    public function __construct($id, $module, DiscountRepository $discounts, UserManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->discounts = $discounts;
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        //  'roles' => ['@'],
                    ],
                    [
                        'actions' => ['tours'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['discount'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['stays'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['cars'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(Url::to(['/login']));
        }

        return $this->render('index');
    }

    public function actionTours()
    {
        $searchModel = new TourSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('tours', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStays()
    {
       /* $searchModel = new StaySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('stays', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); */
    }
    public function actionCars()
    {
        /* $searchModel = new CarsSearch();
         $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

         return $this->render('cars', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
         ]); */
    }
    public function actionToursDelete($id)
    {
//TODO Сделать удаление туров
        /* $tours =  $this->tours->get($id);
         if ($tours->user_id != \Yii::$app->user->id) {
             throw new \DomainException('У вас нет прав для данного тура');
         }
         */
    }

    public function actionDiscount()
    {
        $searchModel = new DiscountSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('discount', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDiscountDraft($id)
    {
        try {
        $this->service->draftDiscount(\Yii::$app->user->id, $id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

}
