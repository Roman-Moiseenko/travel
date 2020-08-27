<?php


namespace frontend\controllers\cabinet;


use yii\filters\AccessControl;
use yii\web\Controller;

class PrintController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        //'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionCheck($id)
    {
        //TODO Печать Чека
    }

    public function actionTour($id)
    {
        //TODO Печать Подтверждения тура
    }
}