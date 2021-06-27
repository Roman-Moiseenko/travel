<?php


namespace admin\controllers\trip;


use booking\entities\booking\trips\Trip;
use booking\helpers\Filling;
use booking\services\booking\trips\TripService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ActivityController extends Controller
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

        return $this->render('view', [
            'trip' => $trip,
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
        return $this->render('create', [
            'trip' => $trip,
        ]);
    }

    public function actionUpdate($id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling)
            if ($trip->filling == Filling::ACTIVITY) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->service->redirect_filling($trip));
            }
        return $this->render('update', [
            'trip' => $trip,
        ]);
    }

    public function actionDelete($id)
    {

    }

    public function actionFilling($id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling && $trip->filling == Filling::ACTIVITY) return $this->redirect($this->service->next_filling($trip));
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