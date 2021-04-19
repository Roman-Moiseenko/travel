<?php


namespace admin\controllers\shop;


use booking\entities\shops\Shop;
use booking\forms\shops\ShopCreateForm;
use booking\helpers\scr;
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
        $shop = $this->findModel($id);
        return $this->render('view', [
            'shop' => $shop,
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main-create';
        $form = new ShopCreateForm();
        //scr::v($form->load(\Yii::$app->request->post()));
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $shop = $this->service->create($form);
                return $this->redirect(['/shop/products/' . $shop->id]);
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
        $shop = $this->findModel($id);
        $form = new ShopCreateForm($shop);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($shop->id, $form);
                return $this->redirect(['/shop/view', 'id' => $shop->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'shop' => $shop
        ]);
    }

    public function actionVerify($id)
    {
        $shop = $this->findModel($id);
        try {
            $this->service->verify($shop->id);
            \Yii::$app->session->setFlash('success', 'Ваш магазин успешно отправлен на Модерацию. Мы постараемся проверить Вашу информацию в кратчайшие сроки. Дождитесь, пожалуйста, результата. ');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionCancel($id)
    {
        $shop = $this->findModel($id);
        try {
            $this->service->cancel($shop->id);
            \Yii::$app->session->setFlash('success', 'Вы успешно отменили модерацию магазина');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDraft($id)
    {
        $shop = $this->findModel($id);
        try {
            $this->service->draft($shop->id);
            \Yii::$app->session->setFlash('success', 'Магазин снят с публикации.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActivate($id)
    {
        $shop = $this->findModel($id);
        try {
            $this->service->activate($shop->id);
            \Yii::$app->session->setFlash('success', 'Магазин активирован.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDeletePhoto($id, $photo_id)
    {
        try {
            $this->service->removePhoto($id, $photo_id);

        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMovePhotoUp($id, $photo_id)
    {
        $this->service->movePhotoUp($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMovePhotoDown($id, $photo_id)
    {
        $this->service->movePhotoDown($id, $photo_id);
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