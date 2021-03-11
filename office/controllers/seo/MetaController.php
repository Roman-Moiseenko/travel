<?php


namespace office\controllers\seo;


use booking\entities\Rbac;
use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\funs\FunRepository;
use booking\repositories\booking\stays\StayRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\services\booking\cars\CarService;
use booking\services\booking\funs\FunService;
use booking\services\booking\stays\StayService;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class MetaController extends Controller
{
    /**
     * @var TourService
     */
    private $tourService;
    /**
     * @var TourRepository
     */
    private $tours;
    /**
     * @var CarService
     */
    private $carService;
    /**
     * @var CarRepository
     */
    private $cars;
    /**
     * @var FunService
     */
    private $funService;
    /**
     * @var FunRepository
     */
    private $funs;
    /**
     * @var StayService
     */
    private $stayService;
    /**
     * @var StayRepository
     */
    private $stays;

    public function __construct(
        $id,
        $module,
        TourService $tourService,
        TourRepository $tours,
        CarService $carService,
        CarRepository $cars,
        FunService $funService,
        FunRepository $funs,
        StayService $stayService,
        StayRepository $stays,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->tourService = $tourService;
        $this->tours = $tours;
        $this->carService = $carService;
        $this->cars = $cars;
        $this->funService = $funService;
        $this->funs = $funs;
        $this->stayService = $stayService;
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
                        'roles' => [Rbac::ROLE_MANAGER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        //список всех пустых мета тегов
    }

    public function actionTours()
    {
        //все туры активные
    }
    //...
    //...
}