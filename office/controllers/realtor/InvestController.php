<?php

namespace office\controllers\realtor;

use booking\entities\Rbac;
use booking\entities\realtor\land\Land;
use booking\entities\realtor\land\Point;
use booking\forms\realtor\land\LandForm;
use booking\repositories\realtor\land\LandRepository;
use booking\services\realtor\land\LandService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

class InvestController extends Controller
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
        $lands = $this->lands->getAll();
        return $this->render('index', ['lands' => $lands]);
    }

    public function actionView($id)
    {
        $land = $this->lands->get($id);
        return $this->render('view', ['land' => $land]);
    }

    public function actionCreate()
    {
        $form = new LandForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                $land = $this->service->create($form);
                return $this->redirect(Url::to(['view', 'id' => $land->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', ['model' => $form]);
    }

    public function actionUpdate($id)
    {
        $land = $this->lands->get($id);
        $form = new LandForm($land);
        if ($form->load(\Yii::$app->request->post()) && $form->validate())
        {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(Url::to(['view', 'id' => $land->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', ['model' => $form, 'land' => $land]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionPoints($id)
    {
        $land = $this->lands->get($id);

        return $this->render('points', ['land' => $land]);
    }

    public function actionCreatePoints()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $id = $params['id'];
                $coords = $params['coords'];
                $this->service->setPoints($id, $coords);
                return 'success ' . $id;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return $this->goHome();
    }
    public function actionClearPoints($id)
    {

        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $id = $params['id'];
                $this->service->clearPoints($id);
                return 'success ' . $id;
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        $this->service->clearPoints($id);
        return $this->redirect(\Yii::$app->request->referrer);
        //return $this->goHome();
    }

    public function actionGetLand()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $land = $this->lands->get($params['id']);
                $coords = [

                        'x' => $land->address->latitude,
                        'y' => $land->address->longitude,

                        'points' => array_map(function (Point $point) {
                            return [$point->latitude, $point->longitude];
                        }, $land->points),
                    ];

                return json_encode($coords);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return $this->goHome();
    }

}