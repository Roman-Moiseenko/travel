<?php

namespace admin\controllers\fun;

use admin\widgest\report\ChartMoneyWidget;
use admin\widgest\report\ChartWidget;
use admin\widgest\report\StaticWidget;
use booking\entities\booking\funs\Fun;
use booking\forms\admin\ChartForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReportController extends Controller
{
    public $layout = 'main-funs';

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
        $fun = $this->findModel($id);
        $form->load(\Yii::$app->request->post());
        return $this->render('index', [
            'form' => $form,
            'fun' => $fun,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Fun::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного развлечения');
            }
            return $model;
        }
        throw new NotFoundHttpException('Тур не найден ID=' . $id);
    }

}