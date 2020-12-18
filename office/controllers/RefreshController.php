<?php


namespace office\controllers;


use booking\entities\Rbac;
use office\widgets\ActiveTopWidget;
use office\widgets\SupportMessageTopBarWidget;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class RefreshController extends Controller
{
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'active' => ['POST'],
                    'message' => ['POST'],
                ],
            ],
        ];
    }
    public function actionActive()
    {
        if (\Yii::$app->request->isAjax) {
            return ActiveTopWidget::widget();
        }
        throw new \DomainException('Нет доступа!');
    }

    public function actionMessage()
    {
        if (\Yii::$app->request->isAjax) {
            return SupportMessageTopBarWidget::widget();
        }
        throw new \DomainException('Нет доступа!');
    }
}