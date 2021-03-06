<?php


namespace office\controllers\finance;


use booking\entities\Rbac;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ReportController extends Controller
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