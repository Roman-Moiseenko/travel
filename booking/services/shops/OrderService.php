<?php


namespace booking\services\shops;


use booking\entities\shops\cart\Cart;
use booking\entities\shops\cart\CartItem;
use booking\entities\shops\order\DeliveryData;
use booking\entities\shops\order\Order;
use booking\entities\shops\order\OrderItem;
use booking\entities\shops\order\StatusHistory;
use booking\entities\shops\products\Product;
use booking\forms\shops\OrderForm;
use booking\repositories\shops\OrderRepository;
use booking\repositories\shops\ProductRepository;
use booking\repositories\user\UserRepository;
use booking\services\ContactService;
use booking\services\TransactionManager;
use booking\services\user\UserManageService;
use yii\web\UploadedFile;


class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orders;
    /**
     * @var ProductRepository
     */
    private $products;
    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var TransactionManager
     */
    private $transaction;
    /**
     * @var ContactService
     */
    private $contacts;
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(
        OrderRepository $orders,
        ProductRepository $products,
        TransactionManager $transaction,
        ContactService $contacts,
        ProductService $productService,
        UserRepository $users
    )
    {
        $this->orders = $orders;
        $this->products = $products;
        $this->productService = $productService;
        $this->transaction = $transaction;
        $this->contacts = $contacts;
        $this->users = $users;
    }

    public function prepare(Cart $cart): bool
    {
        if ($cart->isEmpty()) return false;
        $user = $this->users->getCurrent();
        $shops = [];
        //Разбивка по магазинам
        foreach ($cart->getItems() as $item) {
            $this->productService->checkout($item->getProductId(), $item->getQuantity());
            $shops[$item->getShopId()][] = OrderItem::create($item->getProduct(), $item->getQuantity());;
        }
        //Создание заказов по магазинам и сохранение
        /**
         * @var  $shop_id integer
         * @var  $item CartItem
         */
        foreach ($shops as $shop_id => $items) {
            $order = Order::create(
                \Yii::$app->user->id,
                $shop_id,
                $items,
                '',
                DeliveryData::create(
                    null,
                    $user->personal->address->index,
                    $user->personal->address->town,
                    $user->personal->address->address,
                    false,
                    $user->personal->fullname->getFullname(),
                    $user->personal->phone,
                    null
                ),
            );
            $this->orders->save($order);
        }
        $cart->clear(); //очистка корзины

        return true;
    }

    public function create($order_id, OrderForm $form)
    {
        $order = $this->orders->get($order_id);
        //Заполняем данными
        $order->comment = $form->comment;
        $order->setDelivery(DeliveryData::create(
            $form->method,
            $form->address_index,
            $form->address_city,
            $form->address_street,
            $form->on_hands,
            $form->fullname,
            $form->phone,
            $form->company
        ));

        $order->setStatus(StatusHistory::ORDER_NEW);
        $this->orders->save($order);
        $this->contacts->sendOrder($order);
    }

    public function remove($id): void
    {
        $order = $this->orders->get($id);
        if ($order->isNew() || $order->isPrepare() || $order->isConfirmation()) {
            //* восстанавливаем кол-во товаров  */
            foreach ($order->items as $item) {
                $this->productService->repair($item->product_id, $item->quantity);
            }
            $this->orders->remove($order);
        } else {
            throw new \DomainException('Заказ исполняется. Удалить нельзя!');
        }
    }

    public function removeItem($order_id, $item_id)
    {
        $order = $this->orders->get($order_id);
        $item = $order->getItem($item_id);
        $this->productService->repair($item->product_id, $item->quantity);
        $order->delItem($item_id);
        if (count($order->items) == 0) throw new \DomainException('Отмените заказ, написав причину отмены!');
        $this->orders->save($order);
    }

    public function confirmation($id, $comment = null)
    {
        $order = $this->orders->get($id);
        $order->setStatus(StatusHistory::ORDER_CONFIRMATION, $comment);
        $this->orders->save($order);
        $this->contacts->sendOrder($order);
    }

    public function canceled($id, $comment = null, $console = false)
    {
        $order = $this->orders->get($id);
        $order->setStatus(StatusHistory::ORDER_CANCELED, $comment);
        $this->orders->save($order);
        //* восстанавливаем кол-во товаров  */
        foreach ($order->items as $item) {
            $this->productService->repair($item->product_id, $item->quantity);
        }
        if (!$console) $this->contacts->sendOrder($order);
    }

    public function toPay($id, string $payment_id)
    {
        $order = $this->orders->get($id);
        $order->payment->id = $payment_id;
        $order->payment->date = time(); //хз, но задвоенность
        $order->setStatus(StatusHistory::ORDER_TO_PAY); // заполняем пул сатусов
        $this->orders->save($order);
    }

    public function paidByPaymentId(string $payment_id)
    {
        $order = $this->orders->getByPaymentId($payment_id);
        $order->setStatus(StatusHistory::ORDER_PAID); // заполняем пул сатусов
        $this->orders->save($order);
        $this->contacts->sendOrder($order);
    }

    public function formed($id, $comment = null)
    {
        $order = $this->orders->get($id);
        $order->setStatus(StatusHistory::ORDER_FORMED, $comment);
        $this->orders->save($order);
    }

    public function sent($id, $comment = null)
    {
        $order = $this->orders->get($id);
        $order->setStatus(StatusHistory::ORDER_SENT, $comment);
        $this->orders->save($order);
        $this->contacts->sendOrder($order);
    }

    public function completed($id, UploadedFile $file)
    {
        $order = $this->orders->get($id);
        $order->setStatus(StatusHistory::ORDER_COMPLETED);
        $order->loadDocument($file);
        $this->orders->save($order);
        $this->contacts->sendOrder($order);
    }

    //*************  Для Провайдеров ***************
    public function setStatus($id, $status, $comment = null)
    {
        switch ($status) {
            case StatusHistory::ORDER_CONFIRMATION: $this->confirmation($id, $comment); break;
            case StatusHistory::ORDER_CANCELED: $this->canceled($id, $comment); break;
            case StatusHistory::ORDER_FORMED: $this->formed($id, $comment); break;
            case StatusHistory::ORDER_SENT: $this->sent($id, $comment); break;
            //case StatusHistory::ORDER_COMPLETED: $this->completed($id, $comment); break;
            default:
                throw new \DomainException('Неверный тип статуса');

        }
    }
}