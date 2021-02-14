<?php


namespace admin\controllers;


use admin\forms\HotelSearch;
use admin\forms\StaySearch;
use yii\filters\AccessControl;
use yii\web\Controller;

class HotelsController extends Controller
{
    public $layout ='main';

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
        //$searchModel = new HotelSearch();
       // $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
         //   'searchModel' => $searchModel,
           // 'dataProvider' => $dataProvider,
        ]);
    }
}