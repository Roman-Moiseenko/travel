<?php


namespace office\controllers\finance;


use booking\entities\finance\Refund;
use booking\entities\Rbac;
use booking\services\finance\RefundService;
use office\forms\finance\RefundSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ClientController extends Controller
{

    /**
     * @var RefundService
     */
    private $service;

    public function __construct($id, $module, RefundService $service, $config = [])
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
        $searchModel = new RefundSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRefund($id)
    {
        $this->service->refund($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }
}