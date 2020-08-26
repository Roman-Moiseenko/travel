<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\repositories\booking\BookingRepository;
use booking\repositories\booking\tours\BookingTourRepository;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookingController extends Controller
{
    public $layout = 'cabinet';

    /**
     * @var BookingTourRepository
     */
    private $bookingTours;
    /**
     * @var BookingRepository
     */
    private $bookings;

    public function __construct(
        $id,
        $module,
        BookingTourRepository $bookingTours, //?
        BookingRepository $bookings,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->bookingTours = $bookingTours;
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

    public function actionIndex()
    {
        $bookings = $this->bookings->getActive(\Yii::$app->user->id);
        return $this->render('index', [
            'active' => true,
            'bookings' => $bookings,
        ]);
    }

    public function actionHistory()
    {
        $bookings = $this->bookings->getPast(\Yii::$app->user->id);
        return $this->render('index', [
            'active' => false,
            'bookings' => $bookings,
        ]);
    }


}