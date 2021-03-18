<?php


namespace frontend\controllers\cars;


use booking\entities\Lang;
use booking\helpers\scr;
use booking\services\booking\cars\BookingCarService;
use yii\web\Controller;

class CheckoutController extends Controller
{
    private $service;

    public function __construct($id, $module, BookingCarService $service, $config = [])
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
            $session->set('link', '/cars/checkout/booking'); //куда вернуться после регистрации
            return $this->redirect(['/signup']);
        }
        try {
            $params = $session->get('params') ?? \Yii::$app->request->bodyParams; //параметры вернулись или напрямую с формы
            $session->remove('params');

            $car_id = $params['car_id'];
            $date_from = strtotime($params['date_from']);
            $date_to = strtotime($params['date_to']);
            $count_car = $params['count_car'];
            $delivery = $params['delivery'] ?? false;
            $comment = $params['comment'] ?? null;
            $booking = $this->service->create(
                $car_id,
                $date_from,
                $date_to,
                $count_car,
                $delivery,
                $comment,
            );
            return $this->redirect(['/cabinet/car/view', 'id' => $booking->id]);
        } catch (\Throwable $e) {
            //return $e->getMessage();
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['/car/view', 'id' => $car_id]);
        }
    }
}