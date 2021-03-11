<?php


namespace office\controllers\seo;


use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use booking\entities\Meta;
use booking\entities\Rbac;
use booking\forms\MetaForm;
use booking\helpers\scr;
use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\funs\FunRepository;
use booking\repositories\booking\stays\StayRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\repositories\office\MetaRepository;
use booking\services\booking\cars\CarService;
use booking\services\booking\funs\FunService;
use booking\services\booking\stays\StayService;
use booking\services\booking\tours\TourService;
use office\forms\seo\SeoCarsSearch;
use office\forms\seo\SeoFunsSearch;
use office\forms\seo\SeoStaysSearch;
use office\forms\seo\SeoToursSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
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
    /**
     * @var MetaRepository
     */
    private $metas;

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
        MetaRepository $metas,
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
        $this->metas = $metas;
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
        $metas = $this->metas->getEmptyMeta();
        //список всех пустых мета тегов
        $form = new MetaForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                foreach ($metas as $i => $meta) {
                    if ($meta['class'] == $form->class_name && $meta['id'] == $form->id) {
                        $obj = $meta['class']::FindOne($form->id);
                        $obj->setMeta(new Meta($form->title, $form->description, $form->keywords));
                        $obj->save();
                        unset($metas[$i]);
                        break;
                    }
                }
            } catch (\Throwable $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'objects' => $metas,
            'model' => $form,
        ]);
    }

    public function actionTours()
    {
        $searchModel = new SeoToursSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $form = new MetaForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->tourService->setMeta($form->id, $form);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('tours', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $form,
        ]);
    }

    public function actionCars()
    {
        $searchModel = new SeoCarsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $form = new MetaForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->carService->setMeta($form->id, $form);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('cars', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $form,
        ]);
    }

    public function actionFuns()
    {
        $searchModel = new SeoFunsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $form = new MetaForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->funService->setMeta($form->id, $form);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('funs', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $form,
        ]);
    }

    public function actionStays()
    {
        $searchModel = new SeoStaysSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $form = new MetaForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->stayService->setMeta($form->id, $form);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('stays', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $form,
        ]);
    }
}