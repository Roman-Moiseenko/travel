<?php


namespace admin\controllers\car;

use booking\entities\booking\BaseBooking;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\cars\Car;
use booking\entities\booking\cars\CostCalendar;
use booking\helpers\BookingHelper;
use booking\repositories\booking\cars\BookingCarRepository;
use booking\repositories\booking\cars\CostCalendarRepository;
use booking\services\booking\cars\CarService;
use booking\services\system\LoginService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookingController  extends Controller
{
    public  $layout = 'main-cars';
    /**
     * @var CarService
     */
    private $service;
    /**
     * @var BookingCarRepository
     */
    private $bookings;
    /**
     * @var CostCalendarRepository
     */
    private $cars;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        $id,
        $module,
        CarService $service,
        BookingCarRepository $bookings,
        CostCalendarRepository $cars,
        LoginService $loginService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->bookings = $bookings;
        $this->cars = $cars;
        $this->loginService = $loginService;
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
        $car = $this->findModel($id);
        return $this->render('index', [
            'car' => $car,
            'view_cancel' => $this->loginService->admin()->preferences->view_cancel,
        ]);
    }

    public function actionGetCalendar()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $car_id = $params['car_id'];
            $result = $this->cars->getActiveByCar($car_id);
            return json_encode($result);
        }
    }

    public function actionGetDay()
    {
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $car_id = $params['car_id'];
                $date = strtotime($params['date']);
                $calendar = CostCalendar::find()->andWhere(['car_id' => $car_id])->andWhere(['car_at' => $date])->one();
                return $this->render('_booking-day', [
                    'calendar' => $calendar,
                    'view_cancel' => $this->loginService->admin()->preferences->view_cancel,
                ]);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
    }

    public function actionSetGiveCar()
    {
        $this->layout = 'main_ajax';
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $booking_number = $params['booking_number'];
            /** @var BaseBooking $booking */
            $booking = BookingHelper::getByNumber($booking_number);
            if ($booking && $booking instanceof BookingCar) {
                $booking->setGive();
                $this->bookings->save($booking);
                return '';
            } else {
                \Yii::error('Ошибка! actionSetGiveCar - $booking_number = '. $booking_number);
                return '<span class="badge badge-danger">error!</span>';
            }
        }
    }

    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            if ($model->user_id != $this->loginService->admin()->getId()) {
                throw new \DomainException('У вас нет прав для данного авто');
            }
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая сраница не существует.');
    }
}