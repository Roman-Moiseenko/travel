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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [

        ]);
    }

    public function actionUpdate()
    {

    }

    public function actionOptions()
    {
        return $this->render('options', [

        ]);
    }

    public function actionUpdateOptions()
    {

    }
}