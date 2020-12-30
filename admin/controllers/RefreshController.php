<?php


namespace admin\controllers;

use admin\widgest\BookingTopBarWidget;
use admin\widgest\MessageTopBarWidget;
use admin\widgest\ReviewTopBarWidget;
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
    public function actionReview()
    {
        if (\Yii::$app->request->isAjax) {
            return ReviewTopBarWidget::widget();
        }
        throw new \DomainException('Нет доступа!');
    }

    public function actionMessage()
    {
        if (\Yii::$app->request->isAjax) {
            return MessageTopBarWidget::widget();
        }
        throw new \DomainException('Нет доступа!');
    }

    public function actionBooking()
    {
        if (\Yii::$app->request->isAjax) {
            return BookingTopBarWidget::widget();
        }
        throw new \DomainException('Нет доступа!');
    }
}