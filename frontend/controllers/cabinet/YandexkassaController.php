<?php


namespace frontend\controllers\cabinet;


use booking\helpers\BookingHelper;
use booking\repositories\booking\BookingRepository;
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
use YandexCheckout\Model\Notification\NotificationSucceeded;
use YandexCheckout\Model\Notification\NotificationWaitingForCapture;
use YandexCheckout\Model\NotificationEventType;
use yii\web\Controller;

class YandexkassaController extends Controller
{
    private $yandexkassa = [];
    public $enableCsrfValidation = false;
    /**
     * @var Client
     */
    private $client;
    /**
     * @var PayManageService
     */
    private $service;
    /**
     * @var BookingRepository
     */
    private $bookings;

    public function __construct($id, $module, PayManageService $service, Client $client, BookingRepository $bookings, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->client = $client;
        $this->yandexkassa = \Yii::$app->params['yandexkassa'];
        $this->client->setAuth($this->yandexkassa['login'], $this->yandexkassa['password']);
        $this->service = $service;
        $this->bookings = $bookings;
    }

    public function actionInvoice($id)
    {
        $booking = BookingHelper::getByNumber($id);
        $redirect = \Yii::$app->request->referrer;
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
                                'amount' => ['value' => BookingHelper::merchant($booking), 'currency' => 'RUB'],
                                'vat_code' => 1
                            ],
                        ],
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => \Yii::$app->params['frontendHostInfo'] . $booking->getLinks()['frontend'],
                    ],
                    'capture' => true,
                    'description' => $id,
                ],
                uniqid('', true)
            );
        $booking->setPaymentId($payment->id);

            $redirect = $payment->getConfirmation()->getConfirmationUrl();
            //print_r($payment); //exit();
        $_SESSION['paymentid'] = $payment->id;
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

        return $this->redirect($redirect);
    }


    public function actionResult()
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);
        try {
            $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
                ? new NotificationSucceeded($requestBody)
                : new NotificationWaitingForCapture($requestBody);
            $payment = $notification->getObject();
            $booking = $this->bookings->getByPaymentId($payment->id);
            $this->service->payBooking($booking);
            //$payment_method = $payment->payment_method->getType();
        } catch (\Exception $e) {
            // Обработка ошибок при неверных данных
        }
    }
}