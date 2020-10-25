<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\BookingItemInterface;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\services\finance\PayManageService;
use robokassa\FailAction;
use robokassa\Merchant;
use robokassa\ResultAction;
use robokassa\SuccessAction;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RobokassaController extends Controller
{
    /**
     * @var PayManageService
     */
    private $service;

    public function __construct($id, $module, PayManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /* @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     * @var $id string
     */
    public function actionInvoice($id)
    {
        $booking = BookingHelper::getByNumber($id);

        return $this->getMerchant()->payment(BookingHelper::merchant($booking), $id, 'Payment', null, \Yii::$app->user->identity->email);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'result' => [
                'class' => ResultAction::class,
                'callback' => [$this, 'resultCallback'],
            ],
            'success' => [
                'class' => SuccessAction::class,
                'callback' => [$this, 'successCallback'],
            ],
            'fail' => [
                'class' => FailAction::class,
                'callback' => [$this, 'failCallback'],
            ],
        ];
    }

    public function successCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        //TODO Тестировать после подключения!!!!
        /** @var BookingItemInterface $booking */
        //scr::v(\Yii::$app->user);
//        scr::v(\Yii::$app->request->cookies->get('_identity-koenigs'));
        $booking = BookingHelper::getByNumber((int)$nInvId);
        //return $this->redirect(\Yii::$app->params['frontendHostInfo']);
        return $this->redirect($booking->getLinks()['frontend']);
    }

    public function resultCallback($merchant, $nInvId, $nOutSum, $shp)
    {

        $booking = BookingHelper::getByNumber((int)$nInvId);
        try {
            $this->service->payBooking($booking);
            return 'OK' . $nInvId;
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Url::to(['/']));
        }
    }

    public function failCallback($merchant, $nInvId, $nOutSum, $shp)
    {
        $booking = BookingHelper::getByNumber($nInvId);
        try {
        //    $this->service->fail($order->id);
            return 'OK' . $nInvId;
        } catch (\DomainException $e) {
            return $e->getMessage();
        }
    }

    private function getMerchant(): Merchant
    {
        return \Yii::$app->get('robokassa');
    }
}