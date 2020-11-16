<?php


namespace admin\controllers\car;


use booking\entities\booking\cars\Car;
use booking\entities\booking\tours\Tour;
use booking\repositories\booking\cars\ReviewCarRepository;
use booking\repositories\booking\tours\ReviewTourRepository;
use booking\services\booking\cars\CarService;
use booking\services\booking\tours\TourService;
use booking\services\ContactService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReviewController extends Controller
{
    public  $layout = 'main-cars';
    /**
     * @var CarService
     */
    private $service;
    /**
     * @var ReviewCarRepository
     */
    private $reviews;
    /**
     * @var ContactService
     */
    private $contact;


    public function __construct($id, $module, CarService $service, ReviewCarRepository $reviews,ContactService $contact, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->reviews = $reviews;
        $this->contact = $contact;
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
        $dataProvider = $this->reviews->getAllByCar($car->id);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'car' => $car,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного авто');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}