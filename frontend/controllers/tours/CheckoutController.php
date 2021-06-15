<?php


namespace frontend\controllers\tours;


use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\helpers\scr;
use booking\services\booking\tours\BookingTourService;
use booking\services\system\LoginService;
use yii\web\Controller;

class CheckoutController extends Controller
{

    /**
     * @var BookingTourService
     */
    private $service;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct($id, $module, BookingTourService $service, LoginService $loginService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->loginService = $loginService;
    }

    public function actionBooking()
    {
        $session = \Yii::$app->session;
        if ($session->get('link')) $session->remove('params'); //Небыло возврата по link

        if ($this->loginService->isGuest()) {
            //запоминаем ссесию
            $session->set('params', \Yii::$app->request->bodyParams); //параметры брони
            $session->set('link', '/tours/checkout/booking'); //куда вернуться после регистрации
            return $this->redirect(['/signup']);
        }
        try {
            $params = $session->get('params') ?? \Yii::$app->request->bodyParams; //параметры вернулись или напрямую с формы
            $session->remove('params');

            $booking = $this->service->create(
                $params['calendar_id'],
                new Cost(
                    $params['count-adult'] ?? 0,
                    $params['count-child'] ?? 0,
                    $params['count-preference'] ?? 0
                ),
                $params['time-count'] ?? null,
                $params['capacity-id'] ?? null,
                $params['transfer-id'] ?? null
            );
            return $this->redirect(['/cabinet/tour/view', 'id' => $booking->id]);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }
}