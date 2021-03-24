<?php
namespace frontend\controllers;

use booking\helpers\scr;
use booking\helpers\SysHelper;
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
        $this->layout = 'main_landing';
        $mobile = SysHelper::isMobile();
        $params = \Yii::$app->request->queryParams;
        if (isset($params['_1984'])) {
            //получаем список файлов на карусель
            $path = \Yii::$app->params['staticPath'] . '/files/images/landing/carousel/'; //перенести куда нить в параметры
            $url = \Yii::$app->params['staticHostInfo'] . '/files/images/landing/carousel/'; //перенести куда нить в параметры

            $list = scandir($path);
            $images = [];
            foreach ($list as $item) {
                if ($item == '.' || $item == '..') continue;
                    $images[] = $url . $item;
            }
            return $this->render($mobile ? 'index_mobile' : 'index', [
                'images' => $images,
            ]);
        }

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
