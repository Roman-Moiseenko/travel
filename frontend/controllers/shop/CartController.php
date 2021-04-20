<?php


namespace frontend\controllers\shop;


use booking\repositories\shops\ProductRepository;
use booking\services\shops\CartService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CartController extends Controller
{

    public $layout = 'blank';
    /**
     * @var CartService
     */
    private $service;
    /**
     * @var ProductRepository
     */
    private $products;

    public function __construct($id, $module, CartService $service, ProductRepository $products, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->products = $products;
    }

    public function behaviors()
    {
        return [
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'quantity' => ['POST'],
                    'remove' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $cart = $this->service->getCart();

        return $this->render('index', [
            'cart' => $cart,
        ]);
    }

    public function actionAdd($id)
    {
        $product = $this->products->getForFrontend($id);
        try {
            $this->service->add($product->id, 1);
            \Yii::$app->session->setFlash('success', 'Добавлен в корзину!');
            return $this->redirect(\Yii::$app->request->referrer);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    public function actionSub($id)
    {
        $product = $this->products->getForFrontend($id);
        try {
            $this->service->sub($product->id, 1);
           // \Yii::$app->session->setFlash('success', 'Добавлен в корзину!');
            return $this->redirect(\Yii::$app->request->referrer);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    public function actionQuantity($id)
    {
        try {
            $this->service->set($id, (int)\Yii::$app->request->post('quantity'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    public function actionRemove($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

}