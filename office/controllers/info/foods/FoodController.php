<?php


namespace office\controllers\info\foods;


use booking\entities\foods\ContactAssign;
use booking\entities\foods\Food;
use booking\entities\Rbac;
use booking\forms\admin\ContactAssignmentForm;
use booking\forms\booking\PhotosForm;
use booking\forms\foods\ContactAssignForm;
use booking\forms\foods\FoodForm;
use booking\forms\foods\InfoAddressForm;
use booking\helpers\scr;
use booking\services\foods\FoodService;
use office\forms\info\foods\FoodSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FoodController extends Controller
{
    /**
     * @var FoodService
     */
    private $service;

    public function __construct($id, $module, FoodService $service, $config = [])
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
                    'delete-photo' => ['POST'],
                    'move-photo-up' => ['POST'],
                    'move-photo-down' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new FoodSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        try {
            $food = $this->findModel($id);
            return $this->render('view', [
                'food' => $food,
            ]);
        } catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Url::to('index'));
        }
    }

    public function actionCreate()
    {
        $form = new FoodForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $food = $this->service->create($form);
                return $this->redirect(['info/foods/food/view', 'id' => $food->id]);
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
        $food = $this->findModel($id);
        $form = new FoodForm($food);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($food->id, $form);
                return $this->redirect(['info/foods/food/view', 'id' => $food->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'food' => $food,
        ]);
    }

    public function actionVisible($id)
    {
        $food = $this->findModel($id);
        $this->service->visible($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionPhoto($id)
    {
        $food = $this->findModel($id);
        $form = new PhotosForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addPhotos($food->id, $form);
                return $this->redirect(['info/foods/food/view', 'id' => $food->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('photo', [
            'food' => $food,
            'photosForm' => $form,
        ]);
    }

    public function actionDeletePhoto($id, $photo_id)
    {
        try {
            $this->service->removePhoto($id, $photo_id);

        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/info/foods/food/photo', 'id' => $id, '#' => 'photos']);
    }

    public function actionMovePhotoUp($id, $photo_id)
    {
        $this->service->movePhotoUp($id, $photo_id);
        return $this->redirect(['/info/foods/food/photo', 'id' => $id, '#' => 'photos']);
    }

    public function actionMovePhotoDown($id, $photo_id)
    {
        $this->service->movePhotoDown($id, $photo_id);
        return $this->redirect(['/info/foods/food/photo', 'id' => $id, '#' => 'photos']);
    }

    public function actionAddress($id)
    {
        $food = $this->findModel($id);
        $form = new InfoAddressForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addAddress($food->id, $form);
                return $this->redirect(['info/foods/food/view', 'id' => $food->id]);

            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('address', [
            'food' => $food,
            'model' => $form,
        ]);
    }

    public function actionDeleteAddress($id)
    {
        $params = \Yii::$app->request->queryParams;
        $food = $this->findModel($params['food_id']);
        try {
            $this->service->removeAddress($food->id, $id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['info/foods/food/view', 'id' => $food->id]);
    }

    public function actionContact($id)
    {
        $food = $this->findModel($id);

        $form = new ContactAssignForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addContact($food->id, $form);
                return $this->redirect(\Yii::$app->request->referrer);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('contact', [
            'food' => $food,
            'model' => $form,
        ]);
    }

    public function actionUpdateContact($id)
    {
        $params = \Yii::$app->request->queryParams;
        $food = $this->findModel($params['food_id']);
        $contact = $food->getContactAssignById($id);

        $form = new ContactAssignForm($contact);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->updateContact($food->id, $id, $form);
                return $this->redirect(['info/foods/food/view', 'id' => $food->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('contact', [
            'food' => $food,
            'model' => $form,
        ]);
    }

    public function actionDeleteContact($id)
    {
        $params = \Yii::$app->request->queryParams;
        $food = $this->findModel($params['food_id']);
        try {
            $this->service->removeContact($food->id, $id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['info/foods/food/view', 'id' => $food->id]);
    }

    protected function findModel($id)
    {
        if (($model = Food::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}