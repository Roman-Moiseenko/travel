<?php


namespace office\controllers\guides;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\entities\Rbac;
use booking\forms\office\guides\StayComfortCategoryForm;
use booking\forms\office\guides\StayComfortForm;
use booking\services\office\guides\StayComfortService;
use office\forms\guides\StayComfortCategorySearch;
use office\forms\guides\StayComfortSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class StayComfortController extends Controller
{

    /**
     * @var StayComfortService
     */
    private $service;

    public function __construct($id, $module, StayComfortService $service, $config = [])
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
                        'roles' => [Rbac::ROLE_ADMIN],
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
        $searchModel = new StayComfortSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategories()
    {
        $searchModel = new StayComfortCategorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('categories', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new StayComfortForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['guides/stay-comfort/index']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionCreateCategory()
    {
        $form = new StayComfortCategoryForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createCategory($form);
                return $this->redirect(['guides/stay-comfort/categories']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create-category', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $type = $this->find($id);
        $form = new StayComfortForm($type);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['guides/stay-comfort/index']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    public function actionUpdateCategory($id)
    {
        $category = $this->findCategory($id);
        $form = new StayComfortCategoryForm($category);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editCategory($id, $form);
                return $this->redirect(['guides/stay-comfort/categories']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update-category', [
            'model' => $form,
            'category' => $category,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDeleteCategory($id)
    {
        $this->service->removeCategory($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveUp($id)
    {
        $this->service->moveUp($id);
        return $this->redirect(['index']);
    }

    public function actionMoveDown($id)
    {
        $this->service->moveDown($id);
        return $this->redirect(['index']);
    }

    public function actionMoveUpCategory($id)
    {
        $this->service->moveUpCategory($id);
        return $this->redirect(['categories']);
    }

    public function actionMoveDownCategory($id)
    {
        $this->service->moveDownCategory($id);
        return $this->redirect(['categories']);
    }

    private function find($id)
    {
        if (!$result = Comfort::findOne($id))
            throw new \DomainException('Не найден элемент');
        return $result;
    }

    private function findCategory($id)
    {
        if (!$result = ComfortCategory::findOne($id))
            throw new \DomainException('Не найден элемент');
        return $result;
    }

}