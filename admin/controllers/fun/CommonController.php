<?php


namespace admin\controllers\fun;

use booking\entities\booking\funs\Fun;
use booking\forms\booking\funs\FunCommonForm;
use booking\helpers\BookingHelper;
use booking\services\booking\funs\FunService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommonController extends Controller
{
    public  $layout = 'main-funs';

    private $service;

    public function __construct($id, $module, FunService $service, $config = [])
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
        $fun = $this->findModel($id);
        return $this->render('view', [
            'fun' => $fun
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main-create';
        $form = new FunCommonForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $fun = $this->service->create($form);
                \Yii::$app->session->setFlash('success', 'Тур успешно создан, теперь вы можете загрузить фотографии и настроить остальные параметры');
                return $this->redirect(['/fun/common', 'id' => $fun->id]);
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
        $fun = $this->findModel($id);
        $form = new FunCommonForm($fun);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($fun->id, $form);
                return $this->redirect(['/fun/common', 'id' => $fun->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'fun' => $fun
        ]);

    }

    public function actionVerify($id)
    {
        $fun = $this->findModel($id);
        try {
            $this->service->verify($fun->id);
            \Yii::$app->session->setFlash('success', 'Ваше Развлечение успешно отправлено на Модерацию. Мы постараемся проверить Вашу информацию в кратчайшие сроки. Дождитесь, пожалуйста, результата. ');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionCancel($id)
    {
        $fun = $this->findModel($id);
        try {
            $this->service->cancel($fun->id);
            \Yii::$app->session->setFlash('success', 'Вы успешно отменили модерацию Развлечения');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e);
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDraft($id)
    {
        $fun = $this->findModel($id);
        try {
            $this->service->draft($fun->id);
            \Yii::$app->session->setFlash('success', 'Развлечение снято с публикации.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e);
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActivate($id)
    {
        $fun = $this->findModel($id);
        try {
            $this->service->activate($fun->id);
            \Yii::$app->session->setFlash('success', 'Развлечение опубликовано.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e);
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionSupport($id)
    {
        $fun = $this->findModel($id);
        try {
            $this->service->support($fun->id, BookingHelper::BOOKING_TYPE_FUNS);
            \Yii::$app->session->setFlash('success', 'Запрос отправлен в поддержку');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e);
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Fun::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного Развлечения');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}