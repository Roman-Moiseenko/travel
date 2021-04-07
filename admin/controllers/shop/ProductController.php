<?php


namespace admin\controllers\shop;


use booking\entities\shops\products\Product;
use yii\filters\AccessControl;
use yii\web\Controller;

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
        $searchModel = new ProductSearch($id); //$id - shop_id
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $shop = $this->findModel($id);
        return $this->render('view', [
            'shop' => $shop,
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main-create';
        $form = new ProductCreateForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $shop = $this->service->create($form);
                return $this->redirect(['/shop/product/view', 'id' => $shop->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $shop = $this->findModel($id);
        $form = new ProductCreateForm($shop);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($shop->id, $form);
                return $this->redirect(['/shop/product/view', 'id' => $shop->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'shop' => $shop
        ]);
    }
}