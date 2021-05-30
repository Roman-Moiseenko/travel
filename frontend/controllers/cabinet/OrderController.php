<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\entities\shops\cart\Cart;
use booking\entities\shops\order\Order;
use booking\forms\shops\OrderForm;
use booking\repositories\shops\OrderRepository;
use booking\services\shops\OrderService;
use booking\services\system\LoginService;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrderController extends Controller
{
    public $layout = 'cabinet';
    /**
     * @var OrderService
     */
    private $service;
    /**
     * @var OrderRepository
     */
    private $orders;
    /**
     * @var Cart
     */
    private $cart;
    /**
     * @var LoginService
     */
    //private $loginService;
    private $isGuest;
    private $userId;

    public function __construct(
        $id,
        $module,
        Cart $cart,
        OrderService $service,
        OrderRepository $orders,
        LoginService $loginService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->orders = $orders;
        $this->cart = $cart;
        //$this->loginService = $loginService;
        $this->isGuest = $loginService->isGuest();
        $this->userId = $loginService->user()->getId();
    }

    public function actionIndex()
    {
        //*** надо залогиниться
        $session = \Yii::$app->session;
        if ($this->isGuest) {
            $session->set('link', '/cabinet/orders');
            if (\Yii::$app->request->isPost && \Yii::$app->request->post('prepare') == true) {
                $session->set('prepare', true);
            }
            return $this->redirect(['/signup']);
        }
        //*** Формируем Ордер, если отправка с корзины
        if ((\Yii::$app->request->isPost && \Yii::$app->request->post('prepare') == true) || $session->get('prepare')){
            try {
                $session->remove('prepare');
                if ($this->service->prepare($this->cart)) \Yii::$app->session->setFlash('success', Lang::t('Заказ(ы) сформирован(ы) успешно!'));
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }

        return $this->render('index', [
            'dataProvider' => $this->orders->getNew($this->userId),
            'active' => 'new',
            'counts' => $this->orders->getCountsArray($this->userId),
        ]);
    }

    public function actionWork()
    {
        $session = \Yii::$app->session;
        if ($this->isGuest) {
            $session->set('link', '/cabinet/orders/work'); //куда вернуться после регистрации
            return $this->redirect(['/signup']);
        }
        return $this->render('index', [
            'dataProvider' => $this->orders->getWork($this->userId),
            'active' => 'work',
            'counts' => $this->orders->getCountsArray($this->userId),
        ]);
    }

    public function actionCompleted()
    {
        $session = \Yii::$app->session;
        if ($this->isGuest) {
            $session->set('link', '/cabinet/orders/work'); //куда вернуться после регистрации
            return $this->redirect(['/signup']);
        }
        return $this->render('index', [
            'dataProvider' => $this->orders->getCompleted($this->userId),
            'active' => 'completed',
            'counts' => $this->orders->getCountsArray($this->userId),
        ]);
    }

    public function actionCanceled()
    {
        $session = \Yii::$app->session;
        if ($this->isGuest) {
            $session->set('link', '/cabinet/orders/work'); //куда вернуться после регистрации
            return $this->redirect(['/signup']);
        }
        return $this->render('index', [
            'dataProvider' => $this->orders->getCanceled($this->userId),
            'active' => 'canceled',
            'counts' => $this->orders->getCountsArray($this->userId),
        ]);
    }

    public function actionNew($id)
    {
        //Проверка на Guest
        $order = $this->findModel($id);
        $form = new OrderForm($order);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                //Отправляем заказ на подтверждение в Магазин
                $this->service->create($order->id, $form);

                //TODO Сделать тест если тест, генерим любой код, и вызываем функции
                // 1. $this->orderService->toPay($id, $payment->id);
                // 2. $this->orderService->paidByPaymentId($payment->id);

                //Подтверждения
                //$this->redirect(['cabinet/yandexkassa/invoiceShop', 'id' => $order->id]);
                //TODO На оплату!!!!!!!!!!!!!!!!!!!!!!!!!!!
                return $this->redirect(Url::to(['/cabinet/orders']));
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('new', [
            'order' => $order,
            'model' => $form,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionView($id)
    {
        //Проверка на Guest
        $order = $this->findModel($id);

        return $this->render('view', [
            'order' => $order,
        ]);
    }


    private function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            if ($model->user_id !== $this->userId) {
                throw new \DomainException(Lang::t('У вас нет доступа к данному бронированию'));
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}