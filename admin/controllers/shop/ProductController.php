<?php


namespace admin\controllers\shop;


use admin\forms\shops\ProductSearch;
use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
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
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'shop' => $shop,
        ]);
    }

    public function actionView($id)
    {
        $shop = $this->findModel($id);
        return $this->render('view', [
            'shop' => $shop,
        ]);
    }

    public function actionCreate($id)
    {

        $shop = Shop::findOne($id);
        $form = new ProductForm();
        //scr::v(\Yii::$app->request->post());
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

    private function findModel($id): Product
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}