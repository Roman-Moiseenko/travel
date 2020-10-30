<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use booking\forms\booking\ConfirmationForm;
use booking\helpers\BookingHelper;
use booking\services\booking\tours\BookingTourService;
use booking\services\ContactService;
use yii\filters\AccessControl;
use yii\web\Controller;

class PayController extends Controller
{
    public $layout = 'cabinet';

    /**
     * @var BookingTourService
     */
    private $tourService;
    /**
     * @var ContactService
     */
    private $contact;

    public function __construct($id, $module, BookingTourService $tourService, ContactService $contact, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->tourService = $tourService;
        $this->contact = $contact;
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
        $booking = BookingTour::findOne($id);
        //Тур -> оплата на месте
        if ($booking->getCheckBooking() == BookingHelper::BOOKING_CONFIRMATION) {
            //генерируем код на почту (СМС), сохраняем гдето в базе, отправляем СМС
            $this->tourService->noticeConfirmation($id);
            $form = new ConfirmationForm();
            //через форму ждем код
            if ($form->load(\Yii::$app->request->post()) && $form->validate()){
                try {
                    if ($this->tourService->checkConfirmation($id, $form)) {
                        //если совпал, то подтверждение
                        $this->tourService->confirmation($id);
                        \Yii::$app->session->setFlash('success', Lang::t('Ваше бронирование подтверждено'));
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
        }
        if ($booking->getCheckBooking() == BookingHelper::BOOKING_PAYMENT){
            return $this->redirect(['cabinet/yandexkassa/invoice', 'id' => BookingHelper::number($booking)]);
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