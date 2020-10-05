<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use booking\forms\booking\ConfirmationForm;
use booking\services\booking\tours\BookingTourService;
use yii\filters\AccessControl;
use yii\web\Controller;

class PayController extends Controller
{
    public $layout = 'cabinet';

    /**
     * @var BookingTourService
     */
    private $tourService;

    public function __construct($id, $module, BookingTourService $tourService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->tourService = $tourService;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionTour($id)
    {
        if (\Yii::$app->params['NotPay']) {
            //генерируем код СМС
            //сохраняем гдето в базе
            //отправляем СМС
            $this->tourService->confirmation($id);
            $form = new ConfirmationForm();
            $booking = BookingTour::findOne($id);
            //через форму ждем код
            if ($form->load(\Yii::$app->request->post()) && $form->validate()){
                try {
                    if ($this->tourService->isConfirmation($id, $form)) {
                        //если совпал, то подтверждение
                        $this->tourService->pay($id);
                        \Yii::$app->session->setFlash('success', Lang::t('Ваше бронирование подтвержденно'));
                        return $this->redirect(['/cabinet/tour/view', 'id' => $id]);
                    } else {
                        \Yii::$app->session->setFlash('error', Lang::t('Неверный код подтверждения'));
                    }
                } catch (\DomainException $e) {
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }

            }
            return $this->render('confirmation', [
                'model' => $form,
                'booking' => $booking,
            ]);
        } else {
            //TODO Оплата через кассу
        }
    }

    public function actionStay($id)
    {
        //
    }

    public function actionConfirmation()
    {

    }


}