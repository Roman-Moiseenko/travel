<?php
namespace frontend\controllers;

use booking\helpers\scr;
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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
     * @return mixed
     */
    public function actionIndex()
    {
        //scr::v('!!!!');
        $params = \Yii::$app->request->queryParams;
        if (isset($params['_1984'])) return $this->render('index', []);
        return $this->redirect(['/tours']);
    }

    public function actionUpdate()
    {
        $this->layout ='main-update';
        return $this->render('update', []);
    }

    public function actionMain()
    {
        //TODO Тестовый экшн для будущей главной страницы index
        //TODO Грузим  Экскурсии из Рекомендуем

        return $this->render('index', []);
    }

}
