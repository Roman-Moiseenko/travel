<?php

namespace admin\controllers\stay;

use booking\entities\booking\stays\Stay;
use booking\forms\booking\PhotosForm;
use booking\helpers\Filling;
use booking\services\booking\stays\StayService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PhotosController extends Controller
{
    public  $layout = 'main-stays';
    /**
     * @var StayService
     */
    private $service;

    public function __construct($id, $module, StayService $service, $config = [])
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
        $stay = $this->findModel($id);
        if ($stay->filling && $stay->filling != Filling::PHOTOS) return $this->redirect($this->service->redirect_filling($stay));
        if ($stay->filling) {
            $this->layout = 'main-create';
        }
        $form = new PhotosForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addPhotos($stay->id, $form);
                if ($stay->filling) $this->service->next_filling($stay);
                return $this->redirect(['/stay/photos/index', 'id' => $id, '#' => 'photos']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('view', [
            'stay' => $stay,
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
        return $this->redirect(['/stay/photos/index', 'id' => $id, '#' => 'photos']);
    }

    public function actionMovePhotoUp($id, $photo_id)
    {
        $this->service->movePhotoUp($id, $photo_id);
        return $this->redirect(['/stay/photos/index', 'id' => $id, '#' => 'photos']);
    }

    public function actionMovePhotoDown($id, $photo_id)
    {
        $this->service->movePhotoDown($id, $photo_id);
        return $this->redirect(['/stay/photos/index', 'id' => $id, '#' => 'photos']);
    }

    protected function findModel($id)
    {
        if (($model = Stay::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного жилья');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}