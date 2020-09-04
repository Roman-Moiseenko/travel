<?php


namespace admin\controllers;


use admin\forms\DiscountSearch;
use booking\forms\booking\DiscountForm;
use booking\repositories\booking\DiscountRepository;
use booking\services\admin\UserManageService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class DiscountController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new DiscountSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $form = new DiscountForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addDiscount(\Yii::$app->user->id, $form);
                return $this->redirect(['discount']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionDraft($id)
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