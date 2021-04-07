<?php


namespace office\controllers\guides;


use booking\entities\Rbac;
use booking\entities\shops\products\Category;
use booking\forms\office\guides\ProductCategoryForm;
use booking\services\office\guides\ProductCategoryService;
use office\forms\guides\ProductCategorySearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ProductCategoryController extends Controller
{

    /**
     * @var ProductCategoryService
     */
    private $service;

    public function __construct($id, $module, ProductCategoryService $service, $config = [])
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
        $searchModel = new ProductCategorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'category' => $this->find($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new ProductCategoryForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['guides/product-category/index']);
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
        $category = $this->find($id);
        $form = new ProductCategoryForm($category);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['guides/product-category/index']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'category' => $category,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveDown($id)
    {
        $this->service->moveDown($id);
        return $this->redirect(['index']);
    }

    public function actionMoveUp($id)
    {
        $this->service->moveUp($id);
        return $this->redirect(['index']);
    }

    private function find($id)
    {
        if (!$result = Category::findOne($id))
            throw new \DomainException('Не найден элемент');
        return $result;
    }
}