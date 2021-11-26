<?php


namespace office\controllers\realtor;


use booking\entities\realtor\land\Land;
use booking\entities\Rbac;
use booking\entities\realtor\land\Point;
use booking\forms\realtor\land\LandForm;
use booking\repositories\realtor\land\LandRepository;
use booking\services\realtor\land\LandService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

class MapController extends Controller
{
    /**
     * @var LandService
     */
    private $service;
    /**
     * @var LandRepository
     */
    private $lands;

    public function __construct($id, $module, LandService $service, LandRepository $lands, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->lands = $lands;
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
        return $this->render('index');
    }

    public function actionPage($id)
    {
        $land = Land::findOne($id);

        return $this->render('page', [
            'land' => $land,
        ]);
    }

    public function actionGetLands()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $lands = $this->lands->getAll();
                $array_lands = array_map(function (Land $land) {
                    return [
                        'name' => urldecode($land->name),
                        'id' => $land->id,
                        'slug' => $land->slug,
                        'cost' => $land->cost,
                        'coords' => array_map(function (Point $point) {
                            return [$point->latitude, $point->longitude];
                        }, $land->points),
                    ];
                }, $lands);
                return json_encode($array_lands);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return $this->goHome();
    }

    public function actionCreateLand()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $name = $params['name'];
                $slug = $params['slug'];
                $cost = $params['cost'];
                $coords = $params['coords'];

                $land = $this->service->create_ajax($name, $slug, $cost, $coords);

                return 'success ' . $land->id;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return $this->goHome();
    }

    public function actionUpdateLand()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $name = $params['name'];
                $slug = $params['slug'];
                $cost = $params['cost'];
                $id = $params['id'];

                $land = $this->service->edit_ajax($id, $name, $slug, $cost);

                return 'success ' . $land->id;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return $this->goHome();
    }

    public function actionRemoveLand()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $id = $params['id'];

                $this->service->remove_ajax($id);

                return 'success';
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return $this->goHome();
    }

    public function actionCreate()
    {
        $form = new LandForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(Url::to(['/land']));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }

        return $this->render('create', [
            'model' => $form,
        ]);

    }

    public function actionUpdate($id)
    {
        $land = Land::findOne($id);
        $form = new LandForm($land);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(Url::to(['/land']));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'land' => $land,
        ]);
    }
}