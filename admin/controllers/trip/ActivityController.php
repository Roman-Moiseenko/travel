<?php


namespace admin\controllers\trip;


use booking\entities\booking\trips\activity\Activity;
use booking\entities\booking\trips\Trip;
use booking\forms\booking\trips\ActivityForm;
use booking\helpers\Filling;
use booking\repositories\booking\trips\ActivityRepository;
use booking\services\booking\trips\ActivityService;
use booking\services\booking\trips\TripService;
use booking\services\land\LandService;
use booking\services\system\LoginService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ActivityController extends Controller
{
    public $layout = 'main-trips';
    private $service;
    /**
     * @var ActivityService
     */
    private $serviceActivity;
    /**
     * @var ActivityRepository
     */
    private $activities;
    private $user_id;

    public function __construct(
        $id,
        $module,
        TripService $service,
        ActivityService $serviceActivity,
        ActivityRepository $activities,
        LoginService $loginService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->serviceActivity = $serviceActivity;
        $this->activities = $activities;
        $this->user_id = $loginService->admin()->getId();
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
        $trip = $this->findModel($id);
        if ($trip->filling)
            if ($trip->filling == Filling::ACTIVITY) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->service->redirect_filling($trip));
            }

        return $this->render('index', [
            'trip' => $trip,
        ]);
    }

    public function actionView($id)
    {
        $activity = $this->activities->get($id);
        $trip = $this->findModel($activity->trip_id);
        if ($trip->filling)
            if ($trip->filling == Filling::ACTIVITY) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->service->redirect_filling($trip));
            }

        return $this->render('view', [
            'trip' => $trip,
            'activity' => $activity,
        ]);
    }

    public function actionCreate($id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling)
            if ($trip->filling == Filling::ACTIVITY) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->service->redirect_filling($trip));
            }

        $form = new ActivityForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->serviceActivity->create($trip->id, $form);
                return $this->redirect(Url::to(['/trip/activity', 'id' => $trip->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'trip' => $trip,
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $activity = $this->activities->get($id);
        $trip = $this->findModel($activity->trip_id);
        if ($trip->filling)
            if ($trip->filling == Filling::ACTIVITY) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->service->redirect_filling($trip));
            }

        $form = new ActivityForm($activity);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->serviceActivity->edit($activity->id, $form);
                return $this->redirect(Url::to(['/trip/activity', 'id' => $trip->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'trip' => $trip,
            'model' => $form,
            'activity' => $activity,
        ]);
    }

    public function actionDeletePhoto($id, $photo_id)
    {
        try {
            $this->serviceActivity->removePhoto($id, $photo_id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMovePhotoUp($id, $photo_id)
    {
        $this->serviceActivity->movePhotoUp($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMovePhotoDown($id, $photo_id)
    {
        $this->serviceActivity->movePhotoDown($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelete($id)
    {
        $this->serviceActivity->delete($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionFilling($id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling && $trip->filling == Filling::ACTIVITY) return $this->redirect($this->service->next_filling($trip));
    }

    protected function findModel($id)
    {
        if (($model = Trip::findOne($id)) !== null) {
            if ($model->user_id != $this->user_id) {
                throw new \DomainException('У вас нет прав для данного тура');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}