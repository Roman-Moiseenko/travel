<?php


namespace admin\controllers\shop;


use admin\forms\shops\ProductSearch;
use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
use booking\forms\shops\CostModalForm;
use booking\forms\shops\ProductForm;
use booking\helpers\scr;
use booking\services\shops\ProductService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    public $layout = 'main-shops';
    /**
     * @var ProductService
     */
    private $service;

    public function __construct($id, $module, ProductService $service, $config = [])
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
        $searchModel = new ProductSearch(); //$id - shop_id
        $shop = Shop::findOne($id);
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

        $shop = Shop::findOne($id);
        $form = new ProductForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $product = $this->service->create($shop->id, $form);
                return $this->redirect(['/shop/product/view', 'id' => $product->id]);
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
        $form = new ProductForm($product);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($product->id, $form);
                return $this->redirect(['/shop/product/view', 'id' => $product->id]);
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

    public function actionDeletePhoto($id, $photo_id)
    {
        try {
            $this->service->removePhoto($id, $photo_id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMovePhotoUp($id, $photo_id)
    {
        try {
            $this->service->movePhotoUp($id, $photo_id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMovePhotoDown($id, $photo_id)
    {
        try {
        $this->service->movePhotoDown($id, $photo_id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    private function findModel($id): Product
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}