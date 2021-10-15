<?php


namespace office\controllers\realtor;


use booking\entities\Rbac;
use booking\entities\realtor\Landowner;
use booking\forms\booking\PhotosForm;
use booking\forms\realtor\LandownerForm;
use booking\helpers\StatusHelper;
use booking\repositories\realtor\LandownerRepository;
use booking\services\realtor\LandownerService;
use office\forms\realtor\LandownersSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class LandownersController extends Controller
{
    /**
     * @var LandownerService
     */
    private $service;
    /**
     * @var LandownerRepository
     */
    private $landowners;

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

    public function __construct($id, $module, LandownerService $service, LandownerRepository $landowners, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->landowners = $landowners;
    }

    public function actionIndex()
    {
        $searchModel = new LandownersSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $form = new LandownerForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $page = $this->service->create($form);
                return $this->redirect(['view', 'id' => $page->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionView($id)
    {
        try {
            $landowner = $this->landowners->get($id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->goHome();
        }
        return $this->render('view', [
            'landowner' => $landowner,
        ]);
    }

    public function actionUpdate($id)
    {
        $landowner = $this->landowners->get($id);

        $form = new LandownerForm($landowner);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['view', 'id' => $landowner->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'landowner' => $landowner,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(['index']);
    }

    public function actionActivate($id)
    {
        $this->service->activate($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDraft($id)
    {
        $this->service->draft($id);
        return $this->redirect(\Yii::$app->request->referrer);

    }

    public function actionPhoto($id)
    {
        $landowner = $this->landowners->get($id);

        $form = new PhotosForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addPhotos($landowner->id, $form);
                return $this->redirect(['photo', 'id' => $landowner->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('photo', [
            'landowner' => $landowner,
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
        return $this->redirect(['photo', 'id' => $id, '#' => 'photos']);
    }

    public function actionMovePhotoUp($id, $photo_id)
    {
        $this->service->movePhotoUp($id, $photo_id);
        return $this->redirect(['photo', 'id' => $id, '#' => 'photos']);
    }

    public function actionMovePhotoDown($id, $photo_id)
    {
        $this->service->movePhotoDown($id, $photo_id);
        return $this->redirect(['photo', 'id' => $id, '#' => 'photos']);
    }

}