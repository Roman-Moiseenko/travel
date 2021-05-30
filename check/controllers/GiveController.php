<?php


namespace check\controllers;


use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\Tour;
use booking\entities\check\BookingObject;
use booking\entities\check\User;
use booking\helpers\scr;
use booking\repositories\booking\BookingRepository;
use booking\services\check\GiveOutService;
use booking\services\system\LoginService;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class GiveController extends Controller
{
    public $layout = 'main';
    /**
     * @var GiveOutService
     */
    private $service;
    /**
     * @var BookingRepository
     */
    private $bookings;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        $id,
        $module,
        GiveOutService $service,
        BookingRepository $bookings,
        LoginService $loginService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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
        $user = $this->loginService->check();
        return $this->render('index', [
           'objects' => $user->objects,
        ]);
    }

    public function actionView($id)
    {

        $object = BookingObject::findOne($id);
        $bookings = $this->bookings->getTodayCheck($object->classBooking(), $object->object_id);
        $name = $object->classObject()::findOne($object->object_id)->name;
        if ($object->classObject() == Tour::class)
            $link_selling = Url::to(['selling-tour/index', 'id' => $object->id]);
        if ($object->classObject() == Car::class)
            $link_selling = Url::to(['selling-car/index', 'id' => $object->id]);
        if ($object->classObject() == Fun::class)
            $link_selling = Url::to(['selling-fun/index', 'id' => $object->id]);
        if ($object->classObject() == Stay::class)
            $link_selling = Url::to(['selling-stay/index', 'id' => $object->id]);

        //TODO ** BOOKING_OBJECT **
        return $this->render('view', [
            'bookings' => $bookings,
            'name' => $name,
            'link_selling' => $link_selling,
        ]);
    }

    public function actionGive($id)
    {
        try {
            $params = \Yii::$app->request->queryParams;
            $this->service->giveOut($this->loginService->check()->getId(), $params['type'], $params['id']);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(\Yii::$app->request->referrer);
    }

}