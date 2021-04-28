<?php


namespace frontend\controllers\cabinet;


use booking\entities\admin\User;
use booking\entities\Lang;
use booking\entities\shops\order\Order;
use booking\entities\shops\Shop;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\repositories\booking\BookingRepository;
use booking\services\admin\UserManageService;
use booking\services\finance\MovementService;
use booking\services\finance\PayManageService;
use booking\services\finance\YKassaService;
use booking\services\shops\OrderService;
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
use yii\helpers\Url;
use yii\web\Controller;

class YandexkassaController extends Controller
{
    //private $yandexkassa = [];
    public $enableCsrfValidation = false;

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
    /**
     * @var UserManageService
     */
    private $users;
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var MovementService
     */
    private $movementService;

    public function __construct(
        $id,
        $module,
        PayManageService $service,
        BookingRepository $bookings,
        YKassaService $kassaService,
        UserManageService $users,
        OrderService $orderService,
        MovementService $movementService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->bookings = $bookings;
        $this->kassaService = $kassaService;
        $this->users = $users;
        $this->orderService = $orderService;
        $this->movementService = $movementService;
    }

    public function actionInvoice($id)
    {
        $booking = BookingHelper::getByNumber($id);
        /* test */
        /*$code = uniqid();
        $booking->setPaymentId($code);
        $this->movementService->create($booking);

        $booking = $this->bookings->getByPaymentId($code);
        $this->service->payBooking($booking);

        $this->movementService->paid($code);
        return $this->redirect($booking->getLinks()->frontend);*/
        /* end test */
        try {
            $payment = $this->kassaService->invoice($booking);
            $booking->setPaymentId($payment->id);
            $this->movementService->create($booking);
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
            return $this->redirect($booking->getLinks()->frontend);
        }
    }

    public function actionInvoiceAdmin($id, $amount)
    {
        try {
            $payment = $this->kassaService->invoiceAdmin(User::findOne($id), $amount);
            $this->users->addDeposit($id, $amount, $payment->id);
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
            return $this->redirect(\Yii::$app->params['adminHostInfo']);
        }
    }

    public function actionInvoiceShop($id)
    {
        $order = Order::findOne($id);
        /* test */
        /* $code = uniqid();
         $this->orderService->toPay($id, $code);
         $this->movementService->create(Order::findOne($id));
         $this->orderService->paidByPaymentId($code);
         $this->movementService->paid($code);
         return $this->redirect(Url::to(['/cabinet/orders']));*/
        /* end test */
        try {
            $payment = $this->kassaService->invoiceShop($order);
            $this->orderService->toPay($id, $payment->id);
            $this->movementService->create(Order::findOne($id));
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
            return $this->redirect(Url::to(['/cabinet/orders']));
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
            $metadata = $payment->getMetadata();

            $this->movementService->paid($payment->id);

            if ($metadata['class'] == User::class) { //Пополнение баланса провайдерами
                try {
                    $this->users->ConfirmationToUpDeposit($payment->id);
                } catch (\Throwable $e) {
                    \Yii::$app->errorHandler->logException($e);
                }
                return;
            }
            if ($metadata['class'] == Shop::class) { //Покупка в магазине
                try {
                    $this->orderService->paidByPaymentId($payment->id);
                } catch (\Throwable $e) {
                    \Yii::$app->errorHandler->logException($e);
                }
                return;
            }

            $booking = $this->bookings->getByPaymentId($payment->id);
            if ($booking == null) return;
            $this->service->payBooking($booking);
        } catch (\Exception $e) {
            \Yii::$app->errorHandler->logException($e);
        }
    }

}