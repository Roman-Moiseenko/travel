<?php


namespace admin\controllers\stay;


use booking\entities\booking\BaseBooking;
use booking\entities\booking\stays\BookingStay;
use booking\entities\booking\stays\CostCalendar;
use booking\entities\booking\stays\Stay;
use booking\helpers\BookingHelper;
use booking\repositories\booking\stays\BookingStayRepository;
use booking\repositories\booking\stays\CostCalendarRepository;
use booking\services\booking\stays\BookingStayService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookingController extends Controller
{
    public $layout = 'main-stays';
    /**
     * @var BookingStayService
     */
    private $service;
    /**
     * @var BookingStayRepository
     */
    private $bookings;
    /**
     * @var CostCalendarRepository
     */
    private $stays;

    public function __construct($id, $module, BookingStayService $service, BookingStayRepository $bookings, CostCalendarRepository $stays, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->bookings = $bookings;
        $this->stays = $stays;
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

    public function actionIndex($id)
    {
        $stay = $this->findModel($id);
        return $this->render('index', [
            'stay' => $stay,
            'view_cancel' => \Yii::$app->user->identity->preferences->view_cancel,
        ]);
    }

    public function actionGetCalendar()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $stay_id = $params['stay_id'];
                $result = $this->stays->getActiveByStay($stay_id);
                return json_encode($result);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function actionGetDay()
    {
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $stay_id = $params['stay_id'];
                $date = strtotime($params['date']);
                $calendar = CostCalendar::find()
                    ->andWhere(['stay_id' => $stay_id])
                    ->andWhere(['stay_at' => $date])
                    ->one();

                return $this->render('_booking-day', [
                    'view_cancel' => \Yii::$app->user->identity->preferences->view_cancel,
                    'calendar' => $calendar,
                ]);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function actionSetGiveStay()
    {
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $booking_number = $params['booking_number'];
            /** @var BaseBooking $booking */
            $booking = BookingHelper::getByNumber($booking_number);
            if ($booking && $booking instanceof BookingStay) {
                $booking->setGive();
                $this->bookings->save($booking);
                return '';
            } else {
                \Yii::error('Ошибка! actionSetGiveStay - $booking_number = ' . $booking_number);
                return '<span class="badge badge-danger">error!</span>';
            }
        }
    }

    public function actionCancelProvider($id)
    {
        $this->service->cancelProvider($id);

        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Stay::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного жилища');
            }
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая сраница не существует.');
    }
}