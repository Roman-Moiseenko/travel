<?php


namespace admin\controllers\car;

use booking\entities\booking\cars\Car;
use booking\forms\booking\cars\CarParamsForm;
use booking\helpers\scr;
use booking\services\booking\cars\CarService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ParamsController extends Controller
{
    public  $layout = 'main-cars';
    private $service;

    public function __construct($id, $module, CarService $service, $config = [])
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
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $car = $this->findModel($id);

        return $this->render('view', [
            'car' => $car,
        ]);
    }

    public function actionUpdate($id)
    {
        $car = $this->findModel($id);
        $form = new CarParamsForm($car);
        //scr::p(\Yii::$app->request->post());
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            //scr::v('-');
            try {
                $this->service->setParams($car->id, $form);
                return $this->redirect(['/car/params', 'id' => $car->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        //scr::v('+');
        return $this->render('update', [
            'car' => $car,
            'model' => $form,
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