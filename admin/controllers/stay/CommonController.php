<?php


namespace admin\controllers\stay;

use admin\forms\StaySearch;
use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\StayCommonForm;
use booking\helpers\BookingHelper;
use booking\services\booking\stays\StayService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommonController extends Controller
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
        ];
    }

    public function actionIndex($id)
    {
        $stay = $this->findModel($id);
        if ($stay->filling) return $this->redirect($this->service->redirect_filling($stay));
        return $this->render('view', [
            'stay' => $stay
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main-create';
        $form = new StayCommonForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $stay = $this->service->create($form);
                return $this->redirect($this->service->next_filling($stay));
                /*\Yii::$app->session->setFlash('success', 'Жилище успешно создано, теперь вы можете загрузить фотографии и настроить остальные параметры');
                return $this->redirect(['/stay/common', 'id' => $stay->id]); */
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
        $stay = $this->findModel($id);
        $form = new StayCommonForm($stay);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($stay->id, $form);
                return $this->redirect(['/stay/common', 'id' => $stay->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'stay' => $stay
        ]);

    }

    public function actionVerify($id)
    {
        $stay = $this->findModel($id);
        try {
            $this->service->verify($stay->id);
            \Yii::$app->session->setFlash('success', 'Ваше жилище успешно отправлно на Модерацию. Мы постараемся проверить Вашу информацию в кратчайшие сроки. Дождитесь, пожалуйста, результата. ');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionCancel($id)
    {
        $stay = $this->findModel($id);
        try {
            $this->service->cancel($stay->id);
            \Yii::$app->session->setFlash('success', 'Вы успешно отменили модерацию жилища');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDraft($id)
    {
        $stay = $this->findModel($id);
        try {
            $this->service->draft($stay->id);
            \Yii::$app->session->setFlash('success', 'Жилище снято с публикации.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActivate($id)
    {
        $stay = $this->findModel($id);
        try {
            $this->service->activate($stay->id);
            \Yii::$app->session->setFlash('success', 'Жилище опубликовано.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionSupport($id)
    {
        $stay = $this->findModel($id);
        try {
            $this->service->support($stay->id, BookingHelper::BOOKING_TYPE_STAY);
            \Yii::$app->session->setFlash('success', 'Запрос отправлен в поддержку');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Stay::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного жилища');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}