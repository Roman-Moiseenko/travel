<?php


namespace admin\controllers\trip;


use booking\entities\booking\trips\Trip;
use booking\entities\booking\trips\Video;
use booking\forms\booking\VideosForm;
use booking\helpers\Filling;
use booking\services\booking\trips\TripService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class VideosController extends Controller
{
    public $layout = 'main-trips';
    private $service;

    public function __construct($id, $module, TripService $service, $config = [])
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
                    'delete-video' => ['POST'],
                    'move-video-up' => ['POST'],
                    'move-video-down' => ['POST'],
                    'featured' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex($id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling)
            if ($trip->filling == Filling::VIDEOS) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->service->redirect_filling($trip));
            }
        return $this->render('view', [
            'trip' => $trip,
        ]);
    }

    public function actionCreate($id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling)
            if ($trip->filling == Filling::VIDEOS) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->service->redirect_filling($trip));
            }
        $form = new VideosForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addVideo($trip->id, $form);
                return $this->redirect(['/trip/videos/index', 'id' => $id]);

            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'trip' => $trip,
            'model' => $form,
        ]);
    }

    public function actionUpdateVideo($id, $video_id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling) return $this->redirect($this->service->redirect_filling($trip));
        $form = new VideosForm(Video::findOne($video_id));
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editVideo($trip->id, $video_id, $form);
                return $this->redirect(['/trip/videos/index', 'id' => $id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'trip' => $trip,
            'model' => $form,
        ]);
    }

    public function actionDeleteVideo($id, $video_id)
    {
        try {
            $this->service->removeVideo($id, $video_id);

        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/trip/videos/index', 'id' => $id]);
    }

    public function actionMoveVideoUp($id, $video_id)
    {
        $this->service->moveVideoUp($id, $video_id);
        return $this->redirect(['/trip/videos/index', 'id' => $id]);
    }

    public function actionMoveVideoDown($id, $video_id)
    {
        $this->service->moveVideoDown($id, $video_id);
        return $this->redirect(['/trip/videos/index', 'id' => $id]);
    }

    public function actionFilling($id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling && $trip->filling == Filling::VIDEOS) return $this->redirect($this->service->next_filling($trip));
    }

    protected function findModel($id)
    {
        if (($model = Trip::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного тура');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}