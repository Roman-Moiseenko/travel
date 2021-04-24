<?php


namespace admin\controllers\shop;


use admin\forms\shops\OrderSearch;
use booking\entities\shops\order\Order;
use booking\entities\shops\Shop;
use booking\forms\booking\PhotosForm;
use booking\helpers\scr;
use booking\services\shops\OrderService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class SellingController extends Controller
{
    public $layout = 'main-shops';
    /**
     * @var OrderService
     */
    private $service;

    public function __construct($id, $module, OrderService $service, $config = [])
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
        $searchModel = new OrderSearch(); //$id - shop_id
        try {
            $shop = $this->findShop($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
        $dataProvider = $searchModel->search($id, \Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'shop' => $shop,
        ]);
    }

    public function actionView($id)
    {
        $order = Order::findOne($id);
        return $this->render('view', [
            'order' => $order,
        ]);
    }

    private function findShop($id): Shop
    {
        if (($model = Shop::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного магазина');
            }
            return $model;
        }
        throw new \DomainException('The requested page does not exist.');
    }

    public function actionStatus($id)
    {
        if ((\Yii::$app->request->isPost && \Yii::$app->request->post('status'))){
            try {
                //
                if (isset(\Yii::$app->request->bodyParams['comment'])) {
                    $this->service->setStatus($id, \Yii::$app->request->post('status'), \Yii::$app->request->bodyParams['comment']);
                } else {
                    //scr::v(\Yii::$app->request->bodyParams);
                    //$form = new PhotosForm();
                    $file = UploadedFile::getInstanceByName('document');
                    //$param =
                    //scr::v($file);
                    $this->service->completed($id, $file);
                }
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelItem($order, $item)
    {
        try {
            $this->service->removeItem($order, $item);
            \Yii::$app->session->setFlash('warning', 'Не забудьте в комментарии указать причину удаления данного товара');
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(\Yii::$app->request->referrer);
    }

}