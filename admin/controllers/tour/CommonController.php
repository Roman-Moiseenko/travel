<?php


namespace admin\controllers\tour;


use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\TourCommonForm;
use booking\helpers\BookingHelper;
use booking\repositories\booking\tours\TourRepository;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommonController extends Controller
{
    public  $layout = 'main-tours';
    /**
     * @var TourService
     */
    private $service;

    public function __construct($id, $module, TourService $service, $config = [])
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
        $tour = $this->findModel($id);
        if ($tour->filling) return $this->redirect($this->service->redirect_filling($tour));
        return $this->render('view', [
            'tour' => $tour
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main-create';
        $form = new TourCommonForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $tour = $this->service->create($form);
                if ($tour->filling) {
                    return $this->redirect($this->service->next_filling($tour));
                } else {
                    return $this->redirect(['/tour/common', 'id' => $tour->id]);
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
        $tour = $this->findModel($id);
        $form = new TourCommonForm($tour);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($tour->id, $form);
                if ($tour->filling) {
                    return $this->redirect($this->service->next_filling($tour));
                } else {
                    return $this->redirect(['/tour/common', 'id' => $tour->id]);
                }
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'tour' => $tour
        ]);
    }

    public function actionVerify($id)
    {
        $tour = $this->findModel($id);
        try {
            $this->service->verify($tour->id);
            \Yii::$app->session->setFlash('success', 'Ваш тур успешно отправлен на Модерацию. Мы постараемся проверить Вашу информацию в кратчайшие сроки. Дождитесь, пожалуйста, результата. ');
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
            \Yii::$app->session->setFlash('success', 'Вы успешно отменили модерацию тура');
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
            \Yii::$app->session->setFlash('success', 'Тур снят с публикации.');
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
            \Yii::$app->session->setFlash('success', 'Тур опубликован.');
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
            $this->service->support($tour->id, BookingHelper::BOOKING_TYPE_TOUR);
            \Yii::$app->session->setFlash('success', 'Запрос отправлен в поддержку');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного тура');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}