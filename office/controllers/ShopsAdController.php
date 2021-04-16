<?php


namespace office\controllers;


use booking\entities\Rbac;
use booking\entities\shops\AdShop;
use booking\entities\shops\Shop;
use booking\services\shops\AdShopService;
use booking\services\shops\ShopService;
use office\forms\AdShopsSearch;
use office\forms\ShopsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ShopsAdController extends Controller
{

    /**
     * @var AdShopService
     */
    private $service;

    public function __construct($id, $module, AdShopService $service, $config = [])
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
        $searchModel = new AdShopsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $shop = $this->find($id);

        return $this->render('view', [
            'shop' => $shop,
        ]);
    }

    public function actionActive($id)
    {
        $shop = $this->find($id);
        $this->service->activate($shop->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionLock($id)
    {
        $shop = $this->find($id);
        $this->service->lock($shop->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnlock($id)
    {
        $shop = $this->find($id);
        $this->service->unlock($shop->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }
    public function find($id)
    {
        if (!$shop = AdShop::findOne($id))
            throw new \DomainException('Магазин не найден');
        return $shop;
    }
}