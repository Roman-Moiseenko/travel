<?php

namespace admin\controllers\tour;

use admin\widgest\report\ChartMoneyWidget;
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
            'form' => $form,
            'tour' => $tour,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данной экскурсии');
            }
            return $model;
        }
        throw new NotFoundHttpException('Экскурсия не найден ID=' . $id);
    }

}