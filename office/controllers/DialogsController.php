<?php


namespace office\controllers;


use booking\entities\Rbac;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class DialogsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_MANAGER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        return $this->render('index', [

        ]);
    }
}