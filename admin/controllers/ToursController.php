<?php


namespace admin\controllers;


use admin\forms\TourSearch;
use yii\filters\AccessControl;
use yii\web\Controller;

class ToursController extends Controller
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
        ];
    }

    public function actionIndex()
    {
        $searchModel = new TourSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
//TODO Сделать удаление туров ?
        /* $tours =  $this->tours->get($id);
         if ($tours->user_id != \Yii::$app->user->id) {
             throw new \DomainException('У вас нет прав для данного тура');
         }
         */
    }
}