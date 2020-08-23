<?php


namespace frontend\controllers\tours;


use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\helpers\scr;
use booking\services\booking\tours\BookingTourService;
use yii\web\Controller;

class CheckoutController extends Controller
{

    /**
     * @var BookingTourService
     */
    private $service;

    public function __construct($id, $module, BookingTourService $service, $config = [])
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
            $this->service->create(
                $params['calendar_id'],
                new Cost(
                    $params['count-adult'] ?? 0,
                    $params['count-child'] ?? 0,
                    $params['count-preference'] ?? 0
                ));
            //TODO ссылка на кабинет/бронирования/просмотр
            return $this->redirect(['ссылка на кабинет/бронирования/просмотр']);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }
}