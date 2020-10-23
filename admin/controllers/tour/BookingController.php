<?php


namespace admin\controllers\tour;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Tour;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookingController  extends Controller
{
    public  $layout = 'main-tours';
    /**
     * @var TourService
     */
    private $service;
    /**
     * @var BookingTourRepository
     */
    private $bookings;

    public function __construct($id, $module, TourService $service, BookingTourRepository $bookings, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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

    public function actionIndex($id)
    {
        /** @var BookingTour[] $bookings */
        $params = \Yii::$app->request->bodyParams;
        $only_pay = false;
        if (isset($params['only_pay']) && $params['only_pay'] == true) $only_pay = true;

        $bookings = $this->bookings->getActiveByTour($id, $only_pay);

        $sort_bookings = [];
        foreach ($bookings as $booking) {
            $sort_bookings[$booking->calendar->tour_at][$booking->calendar->time_at][] = $booking;
        }

        $tour = $this->findModel($id);
        return $this->render('index', [
            'tour' => $tour,
            'sort_bookings' => $sort_bookings,
            'only_pay' => $only_pay,
        ]);
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