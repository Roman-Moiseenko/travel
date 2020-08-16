<?php

namespace admin\controllers;


use admin\forms\TourSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        //  'roles' => ['@'],
                    ],
                    [
                        'actions' => ['tours'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(Url::to(['/login']));
        }

        return $this->render('index');
    }

    public function actionTours()
    {
        $searchModel = new TourSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('tours', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionToursDelete($id)
    {
//TODO Сделать удаление туров
        /* $tours =  $this->tours->get($id);
         if ($tours->user_id != \Yii::$app->user->id) {
             throw new \DomainException('У вас нет прав для данного тура');
         }
         */
    }


}
