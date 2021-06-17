<?php


namespace admin\controllers\trip;


use booking\entities\booking\trips\Trip;
use booking\forms\booking\trips\TripCommonForm;
use booking\helpers\BookingHelper;
use booking\services\booking\trips\TripService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommonController extends Controller
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

    public function actionCreate()
    {
        $this->layout = 'main-create';
        $form = new TripCommonForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $trip = $this->service->create($form);
                if ($trip->filling) {
                    return $this->redirect($this->service->next_filling($trip));
                } else {
                    return $this->redirect(['/trip/common', 'id' => $trip->id]);
                }
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
        $trip = $this->findModel($id);
        $form = new TripCommonForm($trip);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($trip->id, $form);
                if ($trip->filling) {
                    return $this->redirect($this->service->next_filling($trip));
                } else {
                    return $this->redirect(['/trip/common', 'id' => $trip->id]);
                }
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'trip' => $trip
        ]);
    }

    public function actionVerify($id)
    {
        $trip = $this->findModel($id);
        try {
            $this->service->verify($trip->id);
            \Yii::$app->session->setFlash('success', 'Ваш тур успешно отправлен на Модерацию. Мы постараемся проверить Вашу информацию в кратчайшие сроки. Дождитесь, пожалуйста, результата. ');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionCancel($id)
    {
        $trip = $this->findModel($id);
        try {
            $this->service->cancel($trip->id);
            \Yii::$app->session->setFlash('success', 'Вы успешно отменили модерацию тура');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDraft($id)
    {
        $trip = $this->findModel($id);
        try {
            $this->service->draft($trip->id);
            \Yii::$app->session->setFlash('success', 'Тур снят с публикации.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActivate($id)
    {
        $trip = $this->findModel($id);
        try {
            $this->service->activate($trip->id);
            \Yii::$app->session->setFlash('success', 'Тур опубликован.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionSupport($id)
    {
        $trip = $this->findModel($id);
        try {
            $this->service->support($trip->id, BookingHelper::BOOKING_TYPE_TRIP);
            \Yii::$app->session->setFlash('success', 'Запрос отправлен в поддержку');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
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