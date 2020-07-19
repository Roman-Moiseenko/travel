<?php


namespace frontend\controllers\cabinet;


use yii\filters\AccessControl;
use yii\web\Controller;

class ProfileController extends Controller
{
    public $layout = 'cabinet';


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionPersonal()
    {

    }

    public function actionPreferences()
    {

    }
}