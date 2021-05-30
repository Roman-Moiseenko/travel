<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\repositories\booking\BookingRepository;
use booking\repositories\booking\tours\BookingTourRepository;
use booking\services\system\LoginService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookingController extends Controller
{
    public $layout = 'cabinet';
    private $bookings;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        $id,
        $module,
        BookingRepository $bookings,
        LoginService $loginService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->bookings = $bookings;
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

    public function actionIndex()
    {
        $bookings = $this->bookings->getActive($this->loginService->user()->getId());
        return $this->render('index', [
            'active' => true,
            'bookings' => $bookings,
        ]);
    }

    public function actionHistory()
    {
        $bookings = $this->bookings->getPast($this->loginService->user()->getId());
        return $this->render('index', [
            'active' => false,
            'bookings' => $bookings,
        ]);
    }


}