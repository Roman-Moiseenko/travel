<?php


namespace booking\services\finance;


use booking\entities\admin\User;
use booking\entities\booking\BaseBooking;
use booking\entities\Lang;
use booking\entities\shops\order\Order;
use booking\entities\shops\Shop;
use booking\helpers\BookingHelper;
use YooKassa\Client;

class YKassaService
{
    /**
     * @var Client
     */
    private $client;
    private $yandexkassa = [];

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->yandexkassa = \Yii::$app->params['yandexkassa'];
        $this->client->setAuth($this->yandexkassa['login'], $this->yandexkassa['password']);
    }

    //Оплата клиентами бронирования
    public function invoice(BaseBooking $booking)
    {
        $payment = $this->client->createPayment(
            [
                'amount' => [
                    'value' => $booking->getPayment()->getPrepay(),
                    'currency' => 'RUB',
                ],
                'payment_method_data' => $this->yandexkassa['payment_method_data'],
                'receipt' => [
                    'customer' => [
                        'full_name' => $booking->user->personal->fullname->getFullname(), //personal->fullname->getFullName(),
                        'email' => $booking->user->email,
                    ],
                    'items' => [
                        [
                            'description' => $booking->getName(),
                            'quantity' => 1,
                            'amount' => ['value' => $booking->getPayment()->getPrepay(), 'currency' => 'RUB'],
                            'vat_code' => 1
                        ],
                    ],
                    'email' => $booking->user->email,
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => \Yii::$app->params['frontendHostInfo'] . $booking->getLinks()->frontend,
                    'locale' => Lang::current() == Lang::DEFAULT ? 'ru_RU' : 'en_US',
                ],
                'capture' => true,
                'description' => $booking->getName() . ' #' . BookingHelper::number($booking),
                'metadata' => [
                    'class' => get_class($booking),
                    'id' => $booking->getId(),
                ],
            ],
            uniqid('', true)
        );
        return $payment;
    }

    //Пополнение баланса провйдерам
    public function invoiceAdmin(User $user, $amount)
    {
        $payment = $this->client->createPayment(
            [
                'amount' => [
                    'value' => $amount,
                    'currency' => 'RUB',
                ],
                'payment_method_data' => $this->yandexkassa['payment_method_data'],
                'receipt' => [
                    'customer' => [
                        'full_name' => $user->personal->fullname->getFullname(),
                        'email' => $user->email,
                    ],
                    'items' => [
                        [
                            'description' => 'Оплата рекламных услуг на сайте Koenigs.ru',
                            'quantity' => 1,
                            'amount' => ['value' => $amount, 'currency' => 'RUB'],
                            'vat_code' => 1
                        ],
                    ],
                    'email' => $user->email,
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => \Yii::$app->params['adminHostInfo'] . '/balance',
                    'locale' => 'ru_RU',
                ],
                'capture' => true,
                'description' => $user->username . ' #' . $amount,
                'metadata' => [
                    'class' => User::class,
                    'id' => $user->id,
                ],
            ],
            uniqid('', true)
        );
        return $payment;
    }

    //Оплата клиентами товаров в корзине

    public function invoiceShop(Order $order)
    {
        $payment = $this->client->createPayment(
            [
                'amount' => [
                    'value' => $order->payment->full_cost,
                    'currency' => 'RUB',
                ],
                'payment_method_data' => $this->yandexkassa['payment_method_data'],
                'receipt' => [
                    'customer' => [
                        'full_name' => $order->user->personal->fullname->getFullname(),
                        'email' => $order->user->email,
                    ],
                    'items' => [
                        [
                            'description' => 'Оплата товара по заказу #' . $order->number,
                            'quantity' => 1,
                            'amount' => ['value' => $order->payment->full_cost, 'currency' => 'RUB'],
                            'vat_code' => 1
                        ],
                    ],
                    'email' => $order->user->email,
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => \Yii::$app->params['frontendHostInfo'] . '/cabinet/orders',
                    'locale' => 'ru_RU',
                ],
                'capture' => true,
                'description' => $order->user->personal->fullname->getFullname() . ' #' . $order->payment->full_cost,
                'metadata' => [
                    'class' => Shop::class,
                    'id' => $order->user_id,
                ],
            ],
            uniqid('', true)
        );
        return $payment;
    }

    public function check($payment_id)
    {
        $receipts = $this->client->getReceipts(['payment_id'=> $payment_id]);
        $items = $receipts->getItems();
        if (count($items) == 0) throw new \DomainException(Lang::t('Чек еще не был сформирован. Попробуйте позже'));
        $item = $items[0];
        if ($item->status != 'succeeded') throw new \DomainException(Lang::t('Чек еще не был сформирован. Попробуйте позже'));
        return $item;
    }

}