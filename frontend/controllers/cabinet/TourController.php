<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use booking\entities\user\User;
use booking\repositories\user\UserRepository;
use booking\services\booking\tours\BookingTourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TourController extends Controller
{
    public $layout = 'cabinet';
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var BookingTourService
     */
    private $bookings;

    public function __construct($id, $module, UserRepository $users, BookingTourService $bookings, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->users = $users;
        $this->bookings = $bookings;
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
        $this->bookings->cancel($booking->id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionCancelpay($id)
    {
        $booking = $this->findModel($id);
        $this->bookings->cancelPay($booking->id);
        //TODO Переход на страницу подтверждения отмены оплаченного тура
        // Затем уведомление .....
        return $this->redirect(\Yii::$app->request->referrer);
    }

    private function findModel($id)
    {
        if (($model = BookingTour::findOne($id)) !== null) {
            if ($model->user_id !== \Yii::$app->user->id) {
                throw new \DomainException(Lang::t('У вас нет доступа к данному бронированию'));
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}