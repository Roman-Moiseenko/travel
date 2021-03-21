<?php


namespace frontend\controllers\stays;


use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\helpers\scr;
use booking\services\booking\stays\BookingStayService;
use yii\web\Controller;

class CheckoutController extends Controller
{

    /**
     * @var BookingStayService
     */
    private $service;

    public function __construct($id, $module, BookingStayService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionBooking()
    {
        $session = \Yii::$app->session;
        if ($session->get('link')) $session->remove('params'); //Небыло возврата по link

        if (\Yii::$app->user->isGuest) {
            //запоминаем ссесию
            $session->set('params', \Yii::$app->request->bodyParams); //параметры брони
            $session->set('link', '/tours/checkout/booking'); //куда вернуться после регистрации
            return $this->redirect(['/signup']);
        }
        try {
            $params = $session->get('params') ?? \Yii::$app->request->bodyParams; //параметры вернулись или напрямую с формы
            scr::p($params);
            $session->remove('params');
            $booking = $this->service->create($params);
            return $this->redirect(['/cabinet/tour/view', 'id' => $booking->id]);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }
}