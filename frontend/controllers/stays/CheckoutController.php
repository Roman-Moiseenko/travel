<?php


namespace frontend\controllers\stays;


use booking\entities\booking\tours\Cost;
use booking\entities\Lang;
use booking\forms\booking\stays\search\SearchStayForm;
use booking\helpers\scr;
use booking\services\booking\stays\BookingStayService;
use booking\services\system\LoginService;
use yii\web\Controller;

class CheckoutController extends Controller
{

    /**
     * @var BookingStayService
     */
    private $service;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct($id, $module, BookingStayService $service, LoginService $loginService, $config = [])
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
            $session->set('link', '/stays/checkout/booking'); //куда вернуться после регистрации
            return $this->redirect(['/signup']);
        }
        try {
            $params = $session->get('params') ?? \Yii::$app->request->bodyParams; //параметры вернулись или напрямую с формы
            $form = new SearchStayForm();
            $form->load($params);
                $session->remove('params');
                $booking = $this->service->create($form);
                return $this->redirect(['/cabinet/stay/view', 'id' => $booking->id]);
            /*} else {
                \Yii::$app->session->setFlash('error', 'Что-то пошло не так!');
                return $this->redirect(\Yii::$app->request->referrer);
            }*/
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }
}