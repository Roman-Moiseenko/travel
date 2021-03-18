<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use booking\forms\booking\ConfirmationForm;
use booking\helpers\BookingHelper;
use booking\services\booking\cars\BookingCarService;
use booking\services\booking\funs\BookingFunService;
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
    /**
     * @var BookingCarService
     */
    private $carService;
    /**
     * @var BookingFunService
     */
    private $funService;

    public function __construct(
        $id,
        $module,
        BookingTourService $tourService,
        BookingCarService $carService,
        BookingFunService $funService,
        ContactService $contact,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->tourService = $tourService;
        $this->contact = $contact;
        $this->carService = $carService;
        $this->funService = $funService;
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
        if ($booking->isPaidLocally()) {
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
        if (!$booking->isPaidLocally()){
            return $this->redirect(['cabinet/yandexkassa/invoice', 'id' => BookingHelper::number($booking)]);
        }
    }

    public function actionCar($id)
    {
        $booking = BookingCar::findOne($id);
        //Авто -> оплата на месте
        if ($booking->isPaidLocally()) {
            //генерируем код на почту (СМС), сохраняем гдето в базе, отправляем СМС
            $this->carService->noticeConfirmation($id);
            $form = new ConfirmationForm();
            //через форму ждем код
            if ($form->load(\Yii::$app->request->post()) && $form->validate()){
                try {
                    if ($this->carService->checkConfirmation($id, $form)) {
                        //если совпал, то подтверждение
                        $this->carService->confirmation($id);
                        \Yii::$app->session->setFlash('success', Lang::t('Ваше бронирование подтверждено'));
                        return $this->redirect(['/cabinet/car/view', 'id' => $id]);
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
        if (!$booking->isPaidLocally()){
            return $this->redirect(['cabinet/yandexkassa/invoice', 'id' => BookingHelper::number($booking)]);
        }
    }

    public function actionFun($id)
    {
        $booking = BookingFun::findOne($id);
        //Тур -> оплата на месте
        if ($booking->isPaidLocally()) {
            //генерируем код на почту (СМС), сохраняем гдето в базе, отправляем СМС
            $this->funService->noticeConfirmation($id);
            $form = new ConfirmationForm();
            //через форму ждем код
            if ($form->load(\Yii::$app->request->post()) && $form->validate()){
                try {
                    if ($this->funService->checkConfirmation($id, $form)) {
                        //если совпал, то подтверждение
                        $this->funService->confirmation($id);
                        \Yii::$app->session->setFlash('success', Lang::t('Ваше бронирование подтверждено'));
                        return $this->redirect(['/cabinet/fun/view', 'id' => $id]);
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
        if (!$booking->isPaidLocally()){
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