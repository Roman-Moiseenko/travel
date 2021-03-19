<?php


namespace admin\controllers\car;


use booking\entities\booking\cars\Car;
use booking\forms\booking\PhotosForm;
use booking\helpers\Filling;
use booking\services\booking\cars\CarService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PhotosController extends Controller
{
    public  $layout = 'main-cars';
    /**
     * @var CarService
     */
    private $service;

    public function __construct($id, $module, CarService $service, $config = [])
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
                        //'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
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
                    'featured' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex($id)
    {
        $car = $this->findModel($id);
        if ($car->filling)
            if ($car->filling == Filling::PHOTOS) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->service->redirect_filling($car));
            }
        $form = new PhotosForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addPhotos($car->id, $form);
                if ($car->filling) {
                    return $this->redirect($this->service->next_filling($car));
                } else {
                    return $this->redirect(['/car/photos/index', 'id' => $id, '#' => 'photos']);
                }
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('view', [
            'car' => $car,
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
        return $this->redirect(['/car/photos/index', 'id' => $id, '#' => 'photos']);
    }

    public function actionMovePhotoUp($id, $photo_id)
    {
        $this->service->movePhotoUp($id, $photo_id);
        return $this->redirect(['/car/photos/index', 'id' => $id, '#' => 'photos']);
    }

    public function actionMovePhotoDown($id, $photo_id)
    {
        $this->service->movePhotoDown($id, $photo_id);
        return $this->redirect(['/car/photos/index', 'id' => $id, '#' => 'photos']);
    }

    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного авто');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}