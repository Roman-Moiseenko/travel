<?php


namespace office\controllers\guides;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\entities\booking\stays\comfort_room\ComfortRoom;
use booking\entities\booking\stays\comfort_room\ComfortRoomCategory;
use booking\entities\Rbac;
use booking\forms\office\guides\StayComfortCategoryForm;
use booking\forms\office\guides\StayComfortForm;
use booking\forms\office\guides\StayComfortRoomCategoryForm;
use booking\forms\office\guides\StayComfortRoomForm;
use booking\services\office\guides\StayComfortRoomService;
use booking\services\office\guides\StayComfortService;
use office\forms\guides\StayComfortCategorySearch;
use office\forms\guides\StayComfortRoomCategorySearch;
use office\forms\guides\StayComfortRoomSearch;
use office\forms\guides\StayComfortSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class StayComfortRoomController extends Controller
{

    /**
     * @var StayComfortService
     */
    private $service;

    public function __construct($id, $module, StayComfortRoomService $service, $config = [])
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
        $searchModel = new StayComfortRoomSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategories()
    {
        $searchModel = new StayComfortRoomCategorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('categories', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new StayComfortRoomForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['guides/stay-comfort-room/index']);
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
        $form = new StayComfortRoomCategoryForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createCategory($form);
                return $this->redirect(['guides/stay-comfort-room/categories']);
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
        $form = new StayComfortRoomForm($type);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['guides/stay-comfort-room/index']);
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
        $form = new StayComfortRoomCategoryForm($category);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editCategory($id, $form);
                return $this->redirect(['guides/stay-comfort-room/categories']);
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
        if (!$result = ComfortRoom::findOne($id))
            throw new \DomainException('Не найден элемент');
        return $result;
    }

    private function findCategory($id)
    {
        if (!$result = ComfortRoomCategory::findOne($id))
            throw new \DomainException('Не найден элемент');
        return $result;
    }

}