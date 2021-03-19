<?php


namespace admin\controllers\car;

use admin\forms\cars\ExtraSearch;
use booking\entities\booking\cars\Car;
use booking\forms\booking\cars\ExtraForm;
use booking\helpers\Filling;
use booking\repositories\booking\cars\ExtraRepository;
use booking\services\booking\cars\CarService;
use booking\services\booking\cars\ExtraService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ExtraController extends Controller
{
    public  $layout = 'main-cars';
    private $service;
    /**
     * @var ExtraRepository
     */
    private $extra;
    /**
     * @var ExtraService
     */
    private $extraService;

    public function __construct($id, $module, CarService $service, ExtraRepository $extra, ExtraService $extraService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->extra = $extra;
        $this->extraService = $extraService;
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
        if ($car->filling)
            if ($car->filling == Filling::EXTRA) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->service->redirect_filling($car));
            }
        $searchModel = new ExtraSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'car' => $car,
        ]);
    }

    public function actionFilling($id)
    {
        $car = $this->findModel($id);
        if ($car->filling && $car->filling == Filling::EXTRA) return $this->redirect($this->service->next_filling($car));
    }

    public function actionSetextra($car_id, $extra_id, $set = false)
    {
        $this->service->setExtra($car_id, $extra_id, $set);
    }

    public function actionCreate($id)
    {
        $car = $this->findModel($id);
        if ($car->filling) { $this->layout = 'main-create';}
        $form = new ExtraForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->extraService->create($car->user_id, $form);
                return $this->redirect(['/car/extra', 'id' => $car->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'car' => $car,
            'model' => $form,
        ]);
    }
    public function actionUpdate($id, $extra_id)
    {
        $car = $this->findModel($id);
        if ($car->filling) { $this->layout = 'main-create';}
        $extra = $this->extra->get($extra_id);
        $form = new ExtraForm($extra);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->extraService->edit($extra->id, $form);
                return $this->redirect(['/car/extra', 'id' => $car->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'car' => $car,
            'extra' => $extra,
            'model' => $form,
        ]);
    }

    public function actionDelete($id, $extra_id)
    {
        $car = $this->findModel($id);
        $this->extraService->remove($extra_id);
        return $this->redirect(['/car/extra', 'id' => $car->id]);
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