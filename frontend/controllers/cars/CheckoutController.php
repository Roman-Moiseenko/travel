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
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для бронирования'));
            return $this->redirect(['/login']);
        }
        try {
            $params = \Yii::$app->request->bodyParams;
            //scr::v($params);
            $car_id = $params['car_id'];
            $date_from = strtotime($params['date_from']);
            $date_to = strtotime($params['date_to']);
            $count_car = $params['count_car'];
            $delivery = $params['delivery'] ?? false;
            $comment = $params['comment'] ?? null;
            $promo = $params['promo'];
            $booking = $this->service->create(
                $car_id,
                $date_from,
                $date_to,
                $count_car,
                $delivery,
                $comment,
                $promo
            );
            return $this->redirect(['/cabinet/car/view', 'id' => $booking->id]);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['/car/view', 'id' => $car_id]);
        }
    }
}