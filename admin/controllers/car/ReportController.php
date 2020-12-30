<?php


namespace admin\controllers\car;

use admin\widgest\report\ChartWidget;
use booking\entities\booking\cars\Car;
use booking\forms\admin\ChartForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReportController extends Controller
{
    public $layout = 'main-cars';

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
        $form = new ChartForm();
        $car = $this->findModel($id);
        $form->load(\Yii::$app->request->post());

        return $this->render('index', [
            'ChartWidget' => ChartWidget::widget([
                'object' => $car,
                'form' => $form,
            ]),
            'car' => $car,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного тура');
            }
            return $model;
        }
        throw new NotFoundHttpException('Тур не найден ID=' . $id);
    }


}