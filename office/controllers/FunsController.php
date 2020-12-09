<?php


namespace office\controllers;


use booking\entities\booking\funs\Fun;
use booking\entities\Rbac;
use booking\services\booking\funs\FunService;
use office\forms\FunsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class FunsController extends Controller
{
    private $service;

    public function __construct($id, $module, FunService $service, $config = [])
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
        $searchModel = new FunsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $fun = $this->find($id);

        return $this->render('view', [
            'fun' => $fun,
        ]);
    }


    public function actionActive($id)
    {
        $fun = $this->find($id);
        $this->service->activate($fun->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionLock($id)
    {
        $fun = $this->find($id);
        $this->service->lock($fun->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnlock($id)
    {
        $fun = $this->find($id);
        $this->service->unlock($fun->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }
    public function find($id)
    {
        if (!$fun = Fun::findOne($id))
            throw new \DomainException('Развлечение не найдено');
        return $fun;
    }
}