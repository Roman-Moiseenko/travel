<?php


namespace frontend\controllers\funs;


use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\helpers\scr;
use booking\services\booking\funs\BookingFunService;
use booking\services\booking\tours\BookingTourService;
use yii\web\Controller;

class CheckoutController extends Controller
{

    /**
     * @var BookingFunService
     */
    private $service;

    public function __construct($id, $module, BookingFunService $service, $config = [])
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
            $session->set('link', '/funs/checkout/booking'); //куда вернуться после регистрации
            return $this->redirect(['/signup']);
        }
        try {
            $params = $session->get('params') ?? \Yii::$app->request->bodyParams; //параметры вернулись или напрямую с формы
            $session->remove('params');

            $booking = $this->service->create(
                $params['fun-id'],
                $params['calendar-id'],
                new Cost(
                    $params['count-adult'] ?? 0,
                    $params['count-child'] ?? 0,
                    $params['count-preference'] ?? 0
                ),
                $params['discount'] ?? null,
                $params['comment'] ?? ''
            );
            return $this->redirect(['/cabinet/fun/view', 'id' => $booking->id]);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }
}