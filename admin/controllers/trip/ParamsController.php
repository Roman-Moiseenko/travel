<?php


namespace admin\controllers\trip;


use booking\entities\booking\trips\Trip;
use booking\forms\booking\trips\TripParamsForm;
use booking\services\booking\trips\TripService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ParamsController extends Controller
{
    public  $layout = 'main-trips';
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
        if ($trip->filling) return $this->redirect($this->service->redirect_filling($trip));
        return $this->render('view', [
            'trip' => $trip
        ]);
    }

    public function actionUpdate($id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling) { $this->layout = 'main-create';}
        $form = new TripParamsForm($trip);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setParams($trip->id, $form);
                if ($trip->filling) {
                    return $this->redirect($this->service->next_filling($trip));
                } else {
                    return $this->redirect(['/trip/params', 'id' => $trip->id]);
                }
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