<?php


namespace admin\controllers\tour;


use booking\entities\booking\BookingItemInterface;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\CostCalendar;
use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookingController extends Controller
{
    public $layout = 'main-tours';
    /**
     * @var TourService
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

    public function __construct($id, $module, TourService $service, BookingTourRepository $bookings, CostCalendarRepository $tours, $config = [])
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
        /** @var BookingTour[] $bookings */
        /*  $params = \Yii::$app->request->bodyParams;
          $only_pay = false;
          if (isset($params['only_pay']) && $params['only_pay'] == true) $only_pay = true;

          $bookings = $this->bookings->getActiveByTour($id, $only_pay);

          $sort_bookings = [];
          foreach ($bookings as $booking) {
              $sort_bookings[$booking->calendar->tour_at][$booking->calendar->time_at][] = $booking;
          }
  */
        $tour = $this->findModel($id);
        return $this->render('index', [
            'tour' => $tour,
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
            $bookings = BookingTour::find()
                ->andWhere(
                    [
                        'IN',
                        'calendar_id',
                        CostCalendar::find()->select('id')->andWhere(['tours_id' => $tour_id])->andWhere(['tour_at' => $date])
                    ]
                )->all();
            return $this->render('_booking-day', [
                'bookings' => $bookings,
            ]);
        }
    }

    public function actionSetGiveTour()
    {
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $booking_number = $params['booking_number'];
            /** @var BookingItemInterface $booking */
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