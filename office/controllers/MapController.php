<?php


namespace office\controllers;


use booking\entities\blog\map\Maps;
use booking\entities\blog\map\Point;
use booking\entities\Rbac;
use booking\forms\blog\map\MapsForm;
use booking\forms\blog\map\PointForm;
use booking\helpers\scr;
use booking\services\blog\MapService;
use office\forms\MapSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MapController extends Controller
{
    /**
     * @var MapService
     */
    private $service;


    public function __construct($id, $module, MapService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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
        $searchModel = new MapSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'map' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new MapsForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $page = $this->service->create($form);
                return $this->redirect(['view', 'id' => $page->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $map = $this->findModel($id);
        $form = new MapsForm($map);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['view', 'id' => $map->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'map' => $map,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    public function actionAddPoint($id)
    {
        $form = new PointForm();
        $map = $this->findModel($id);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                //scr::p(\Yii::$app->request->post());
                $this->service->addPoint($id, $form);
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('add-point', [
            'model' => $form,
            'map' => $map,
        ]);
    }

    public function actionUpdatePoint($id)
    {
        $point = Point::findOne($id);
        $form = new PointForm($point);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editPoint($point->map_id, $id, $form);
                return $this->redirect(['view', 'id' => $point->map_id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update-point', [
            'model' => $form,
            'map' => $point->map,
            'point' => $point,
        ]);
    }

    public function actionDeletePoint($id)
    {
        $point = Point::findOne($id);
        $map_id = $point->map_id;
        try {
            $this->service->removePoint($map_id, $id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $map_id]);
    }

    protected function findModel($id)
    {
        if (($model = Maps::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}