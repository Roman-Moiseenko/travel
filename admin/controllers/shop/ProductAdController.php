<?php


namespace admin\controllers\shop;


use admin\forms\shops\AdProductSearch;
use admin\forms\shops\ProductSearch;
use booking\entities\shops\AdShop;
use booking\entities\shops\products\AdProduct;
use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
use booking\forms\shops\AdProductForm;
use booking\forms\shops\CostModalForm;
use booking\forms\shops\ProductForm;
use booking\helpers\scr;
use booking\services\shops\AdProductService;
use booking\services\shops\ProductService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProductAdController extends Controller
{
    public $layout = 'main-shops-ad';
    /**
     * @var AdProductService
     */
    private $service;

    public function __construct($id, $module, AdProductService $service, $config = [])
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
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $searchModel = new AdProductSearch(); //$id - shop_id
        $shop = AdShop::findOne($id);
        $dataProvider = $searchModel->search($id, \Yii::$app->request->queryParams);
        $form = new CostModalForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setCost($form);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'shop' => $shop,
            'model' => $form,
        ]);
    }

    public function actionView($id)
    {
        $product = $this->findModel($id);
        return $this->render('view', [
            'shop' => $product->shop,
            'product' => $product,
        ]);
    }

    public function actionCreate($id)
    {

        $shop = AdShop::findOne($id);
        $form = new AdProductForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $product = $this->service->create($shop->id, $form);
                return $this->redirect(['/shop-ad/product/', 'id' => $product->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'shop' => $shop,
        ]);
    }

    public function actionUpdate($id)
    {
        $product = $this->findModel($id);
        $form = new AdProductForm($product);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($product->id, $form);
                return $this->redirect(['/shop-ad/product/', 'id' => $product->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'shop' => $product->shop,
            'product' => $product,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActive($id)
    {
        try {
            $this->service->active($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDraft($id)
    {
        try {
        $this->service->draft($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    private function findModel($id): AdProduct
    {
        if (($model = AdProduct::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}