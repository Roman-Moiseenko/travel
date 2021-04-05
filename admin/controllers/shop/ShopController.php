<?php


namespace admin\controllers\shop;


use booking\entities\shops\Shop;
use booking\services\shops\ShopService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ShopController extends Controller
{
    public $layout = 'main-shops';
    /**
     * @var ShopService
     */
    private $service;

    public function __construct($id, $module, ShopService $service, $config = [])
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

    public function actionView($id)
    {

    }

    public function actionCreate($id)
    {

    }

    public function actionUpdate($id)
    {

    }

    public function actionDelete($id)
    {

    }

    public function actionVerify($id)
    {
        $tour = $this->findModel($id);
        try {
            $this->service->verify($tour->id);
            \Yii::$app->session->setFlash('success', 'Ваш магазин успешно отправлен на Модерацию. Мы постараемся проверить Вашу информацию в кратчайшие сроки. Дождитесь, пожалуйста, результата. ');
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
            \Yii::$app->session->setFlash('success', 'Вы успешно отменили модерацию магазина');
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
            \Yii::$app->session->setFlash('success', 'Магазин снят с публикации.');
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
            \Yii::$app->session->setFlash('success', 'Магазин активирован.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    private function findModel($id): Shop
    {
        if (($model = Shop::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного магазина');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}