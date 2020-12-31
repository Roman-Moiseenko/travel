<?php

namespace admin\controllers\tour;

use admin\widgest\report\ChartWidget;
use admin\widgest\report\PaymentNextWidget;
use admin\widgest\report\PaymentPastWidget;
use admin\widgest\report\StaticWidget;
use booking\entities\booking\tours\Tour;
use booking\forms\admin\ChartForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReportController extends Controller
{
    public $layout = 'main-tours';

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
        $tour = $this->findModel($id);
        $form->load(\Yii::$app->request->post());

        return $this->render('index', [
            'ChartWidget' => ChartWidget::widget([
                'object' => $tour,
                'form' => $form,
            ]),
            'PaymentPastWidget' => PaymentPastWidget::widget([

            ]),
            'PaymentNextWidget' => PaymentNextWidget::widget([

            ]),
            'StaticWidget' => StaticWidget::widget([

            ]),
            'tour' => $tour,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного тура');
            }
            return $model;
        }
        throw new NotFoundHttpException('Тур не найден ID=' . $id);
    }

}