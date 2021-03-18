<?php


namespace admin\controllers\tour;


use booking\entities\booking\BaseBooking;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\services\booking\tours\BookingTourService;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookingController extends Controller
{
    public $layout = 'main-tours';
    /**
     * @var BookingTourService
     */
    private $service;
    /**
     * @var BookingTourRepository
     */
    private $bookings;
    /**
     * @var CostCalendarRepository
     */
    private $tours;

    public function __construct($id, $module, BookingTourService $service, BookingTourRepository $bookings, CostCalendarRepository $tours, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->bookings = $bookings;
        $this->tours = $tours;
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
        $tour = $this->findModel($id);
        return $this->render('index', [
            'tour' => $tour,
            'view_cancel' => \Yii::$app->user->identity->preferences->view_cancel,
        ]);
    }

    public function actionGetCalendar()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $tour_id = $params['tour_id'];
            $result = $this->tours->getActiveByTour($tour_id);
            return json_encode($result);
        }
    }

    public function actionGetDay()
    {
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $tour_id = $params['tour_id'];
            $date = strtotime($params['date']);
            $calendars = CostCalendar::find()
                ->andWhere(['tours_id' => $tour_id])
                ->andWhere(['tour_at' => $date])
                ->orderBy(['time_at' => SORT_ASC])
                ->all();

            return $this->render('_booking-day-calendar', [
                'calendars' => $calendars,
                'view_cancel' => \Yii::$app->user->identity->preferences->view_cancel,
            ]);
/*
            $times = CostCalendar::find()->select('time_at')->andWhere(['tours_id' => $tour_id])->andWhere(['tour_at' => $date])->column();
            $_bookings = [];
            foreach ($times as $time) {
                $bookings = BookingTour::find()
                    ->andWhere(
                        [
                            'IN',
                            'calendar_id',
                            CostCalendar::find()->select('id')->andWhere(['tours_id' => $tour_id])->andWhere(['tour_at' => $date])->andWhere(['time_at' => $time])
                        ]
                    );
                if (!\Yii::$app->user->identity->preferences->view_cancel) {
                    $bookings = $bookings->andWhere(['<>', 'status', BookingHelper::BOOKING_STATUS_CANCEL])
                        ->andWhere(['<>', 'status', BookingHelper::BOOKING_STATUS_CANCEL_PAY]);
                }
                $bookings = $bookings->all();
                $_bookings[$time] = $bookings;
            }

            return $this->render('_booking-day', [
                'times' => $_bookings,
                'view_cancel' => \Yii::$app->user->identity->preferences->view_cancel,
            ]);*/
        }
    }

    public function actionSetGiveTour()
    {
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $booking_number = $params['booking_number'];
            /** @var BaseBooking $booking */
            $booking = BookingHelper::getByNumber($booking_number);
            if ($booking && $booking instanceof BookingTour) {
                $booking->setGive();
                $this->bookings->save($booking);
                return '';
            } else {
                \Yii::error('Ошибка! actionSetGiveTour - $booking_number = ' . $booking_number);
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
        if (($model = Tour::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного тура');
            }
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая сраница не существует.');
    }
}