<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\stays\BookingStay;
use booking\entities\Lang;
use booking\forms\booking\ConfirmationForm;
use booking\repositories\user\UserRepository;
use booking\services\booking\stays\BookingStayService;
use booking\services\finance\RefundService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StayController extends Controller
{

    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var BookingStayService
     */
    private $bookings;
    /**
     * @var RefundService
     */
    private $refund;

    public function __construct(
        $id,
        $module,
        UserRepository $users,
        BookingStayService $bookings,
        RefundService $refund,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->users = $users;
        $this->bookings = $bookings;
        $this->refund = $refund;
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

    public function actionView($id)
    {
        $booking = $this->findModel($id);
        $user = $this->users->get(\Yii::$app->user->id);
        return $this->render('view', [
            'booking' => $booking,
            'user' => $user,
        ]);
    }

    public function actionUpdate($id)
    {
        $booking = $this->findModel($id);
    }

    public function actionDelete($id)
    {
        $booking = $this->findModel($id);
        if ($booking->isPay() || $booking->isCancel()) throw new \DomainException(Lang::t('Нельзя отменить бронирование!'));
        $this->bookings->cancel($booking->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionCancelpay($id)
    {
        $booking = $this->findModel($id);
        if (!$booking->calendar->tour->isCancellation($booking->calendar->tour_at))
            throw new \DomainException(Lang::t('Нельзя отменить бронирование!'));
        $this->bookings->noticeConfirmation($id, 'cancel');
        $form = new ConfirmationForm();
        //через форму ждем код
        if ($form->load(\Yii::$app->request->post()) && $form->validate()){
            try {
                if ($this->bookings->checkConfirmation($id, $form)) {
                    //если совпал, то подтверждение
                    $this->bookings->cancelPay($booking->id);
                    $this->refund->create($booking);
                    \Yii::$app->session->setFlash('success', Lang::t('Ваше бронирование отменено. Оплата поступит в течение 7 банковских дней'));
                    return $this->redirect(['/cabinet/stay/view', 'id' => $id]);
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

    private function findModel($id)
    {
        if (($model = BookingStay::findOne($id)) !== null) {
            if ($model->user_id !== \Yii::$app->user->id) {
                throw new \DomainException(Lang::t('У вас нет доступа к данному бронированию'));
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}