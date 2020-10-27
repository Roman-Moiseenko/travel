<?php


namespace frontend\controllers\cabinet;


use booking\helpers\BookingHelper;
use booking\services\finance\PayManageService;
use YandexCheckout\Client;
use YandexCheckout\Common\Exceptions\ApiException;
use YandexCheckout\Common\Exceptions\BadApiRequestException;
use YandexCheckout\Common\Exceptions\ForbiddenException;
use YandexCheckout\Common\Exceptions\InternalServerError;
use YandexCheckout\Common\Exceptions\NotFoundException;
use YandexCheckout\Common\Exceptions\ResponseProcessingException;
use YandexCheckout\Common\Exceptions\TooManyRequestsException;
use YandexCheckout\Common\Exceptions\UnauthorizedException;
use yii\web\Controller;

class YandexkassaController extends Controller
{
    private $yandexkassa = [];
    /**
     * @var Client
     */
    private $client;
    /**
     * @var PayManageService
     */
    private $service;

    public function __construct($id, $module, PayManageService $service, Client $client, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->client = $client;
        $this->yandexkassa = \Yii::$app->params['yandexkassa'];
        $this->client->setAuth($this->yandexkassa['login'], $this->yandexkassa['password']);
        $this->service = $service;
    }

    public function actionInvoice($id)
    {
        $booking = BookingHelper::getByNumber($id);

       // return $this->getMerchant()->payment(BookingHelper::merchant($booking), $id, 'Payment', null, \Yii::$app->user->identity->email);

        // $this->yandexkassa['confirmation']['return_url'] .= $order->id;
        try {
            $payment = $this->client->createPayment(
                [
                    'amount' => [
                        'value' => 1,//$order->cost,
                        'currency' => 'RUB',
                    ],
                    'payment_method_data' => $this->yandexkassa['payment_method_data'],
                    'receipt' => [
                        'email' => \Yii::$app->user->identity->email,
                        // 'phone' => '7' . $user->phone,
                        'items' => [
                            [
                                'description' => 'Бронь ' . $booking->getName(),
                                'quantity' => 1,
                                'amount' => ['value' => BookingHelper::merchant($booking)/*$orderItem->price*/, 'currency' => 'RUB'],
                                'vat_code' => 1
                            ],
                        ],
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => 'https://koenigs.ru/cabinet/yandexkassa/responce?id=' . $id,
                    ],
                    'capture' => true,
                    'description' => 'Бронь № ' . $id,
                ],
                uniqid('', true)
            );
        } catch (BadApiRequestException $e) {
        } catch (ForbiddenException $e) {
        } catch (InternalServerError $e) {
        } catch (NotFoundException $e) {
        } catch (ResponseProcessingException $e) {
        } catch (TooManyRequestsException $e) {
        } catch (UnauthorizedException $e) {
        } catch (ApiException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['/cabinet/order/view', 'id' => $id]);
        }

        $booking->payment_id = $payment->id;
        $booking->save();
        $redirect = $payment->getConfirmation()->getConfirmationUrl();
        //print_r($payment); //exit();
        $_SESSION['paymentid'] = $payment->id;
        return $this->redirect($redirect);
    }

}