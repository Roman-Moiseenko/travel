<?php


namespace admin\controllers\car;


use booking\entities\booking\cars\Car;
use booking\forms\booking\cars\CarFinanceForm;
use booking\repositories\booking\cars\CarRepository;
use booking\services\booking\cars\CarService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FinanceController extends Controller
{
    public $layout = 'main-cars';
    private $service;
    private $cars;

    public function __construct(
        $id,
        $module,
        CarService $service,
        CarRepository $cars,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->cars = $cars;
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
        if ($car->filling) { $this->layout = 'main-create';}
        $form = new CarFinanceForm($car);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                //scr::p([$form->check_booking, \Yii::$app->request->post()]);
                $this->service->setFinance($car->id, $form);
                if ($car->filling) {
                    \Yii::$app->session->setFlash('success', 'Авто успешно создано! Заполните календарь и отправьте на модерацию с раздела Описание');
                    return $this->redirect($this->service->next_filling($car));
                } else {
                    return $this->redirect(['/car/finance', 'id' => $car->id]);
                }
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'car' => $car,
            'model' => $form,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного Авто');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}