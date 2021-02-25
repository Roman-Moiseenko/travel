<?php


namespace admin\controllers\car;


use booking\entities\booking\cars\Car;
use booking\forms\booking\cars\CarCommonForm;
use booking\helpers\BookingHelper;
use booking\services\booking\cars\CarService;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommonController extends Controller
{
    public  $layout = 'main-cars';
    /**
     * @var TourService
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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $car = $this->findModel($id);
        return $this->render('view', [
            'car' => $car
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main-create';
        $form = new CarCommonForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $tour = $this->service->create($form);
                \Yii::$app->session->setFlash('success', 'Авто успешно создано, теперь вы можете загрузить фотографии и настроить остальные параметры');
                return $this->redirect(['/car/common', 'id' => $tour->id]);
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
        $car = $this->findModel($id);
        $form = new CarCommonForm($car);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($car->id, $form);
                return $this->redirect(['/car/common', 'id' => $car->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'car' => $car
        ]);
    }

    public function actionVerify($id)
    {
        $tour = $this->findModel($id);
        try {
            $this->service->verify($tour->id);
            \Yii::$app->session->setFlash('success', 'Ваше авто успешно отправлен на Модерацию. Мы постараемся проверить Вашу информацию в кратчайшие сроки. Дождитесь, пожалуйста, результата. ');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionCancel($id)
    {
        $tour = $this->findModel($id);
        try {
            $this->service->cancel($tour->id);
            \Yii::$app->session->setFlash('success', 'Вы успешно отменили модерацию авто');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDraft($id)
    {
        $tour = $this->findModel($id);
        try {
            $this->service->draft($tour->id);
            \Yii::$app->session->setFlash('success', 'Авто снято с публикации.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActivate($id)
    {
        $tour = $this->findModel($id);
        try {
            $this->service->activate($tour->id);
            \Yii::$app->session->setFlash('success', 'Авто опубликовано.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionSupport($id)
    {
        $tour = $this->findModel($id);
        try {
            $this->service->support($tour->id, BookingHelper::BOOKING_TYPE_CAR);
            \Yii::$app->session->setFlash('success', 'Запрос отправлен в поддержку');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
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