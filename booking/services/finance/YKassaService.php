<?php


namespace booking\services\finance;


use booking\entities\booking\BaseBooking;
use booking\entities\finance\Check54;
use booking\entities\Lang;
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
                            'full_name' => \Yii::$app->user->identity->username, //personal->fullname->getFullName(),
                            'email' => \Yii::$app->user->identity->email,
                        ],
                        'items' => [
                            [
                                'description' => $booking->getName(),
                                'quantity' => 1,
                                'amount' => ['value' => $booking->getPayment()->getPrepay(), 'currency' => 'RUB'],
                                'vat_code' => 1
                            ],
                        ],
                        'email' => \Yii::$app->user->identity->email,
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