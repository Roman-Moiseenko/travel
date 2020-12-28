<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\repositories\booking\BookingRepository;
use booking\services\finance\PayManageService;
use booking\services\finance\YKassaService;
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
    //private $yandexkassa = [];
    public $enableCsrfValidation = false;
    /**
     * @var Client
     */
    //private $client;
    /**
     * @var PayManageService
     */
    private $service;
    /**
     * @var BookingRepository
     */
    private $bookings;
    /**
     * @var YKassaService
     */
    private $kassaService;

    public function __construct(
        $id,
        $module,
        PayManageService $service,
        //Client $client,
        BookingRepository $bookings,
        YKassaService $kassaService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        //$this->client = $client;
        //$this->yandexkassa = \Yii::$app->params['yandexkassa'];
        //$this->client->setAuth($this->yandexkassa['login'], $this->yandexkassa['password']);
        $this->service = $service;
        $this->bookings = $bookings;
        $this->kassaService = $kassaService;
    }

    public function actionInvoice($id)
    {
        $booking = BookingHelper::getByNumber($id);
        try {
            /*$payment = $this->client->createPayment(
                [
                    'amount' => [
                        'value' => BookingHelper::merchant($booking),
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
                                'amount' => ['value' => BookingHelper::merchant($booking), 'currency' => 'RUB'],
                                'vat_code' => 1
                            ],
                        ],
                        'email' => \Yii::$app->user->identity->email,
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => \Yii::$app->params['frontendHostInfo'] . $booking->getLinks()['frontend'],
                        'locale' => Lang::current() == Lang::DEFAULT ? 'ru_RU' : 'en_US',
                    ],
                    'capture' => true,
                    'description' => $booking->getName() . ' #' . $id,
                    'metadata' => [
                        'class' => get_class($booking),
                        'id' => $booking->id,
                    ],
                ],
                uniqid('', true)
            ); */
            $payment = $this->kassaService->invoice($booking);
            $booking->setPaymentId($payment->id);
            return $this->redirect($payment->getConfirmation()->getConfirmationUrl());
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
            return $this->redirect($booking->getLinks()['frontend']);
        }
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
        } catch (\Exception $e) {
            \Yii::$app->errorHandler->logException($e);
        }
    }

}