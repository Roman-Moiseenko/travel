<?php
namespace frontend\controllers;

use booking\helpers\scr;
use booking\helpers\SysHelper;
use booking\services\system\LoginService;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @var LoginService
     */
    private $loginService;

    /**
     * {@inheritdoc}
     */
    public function __construct($id, $module, LoginService $loginService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->loginService = $loginService;
    }

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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        //if ($mobile) return $this->redirect(['/tours']);
        $params = \Yii::$app->request->queryParams;
        //if (isset($params['_1984'])) {
            //получаем список файлов на карусель

        $path = __DIR__ . '/../web/' . \Yii::$app->params['url_img_landing'] . 'carousel/';//\Yii::$app->params['staticPath'] . '/files/images/landing/carousel/'; //перенести куда нить в параметры
        $url = $url_img_booking = \Yii::$app->params['url_img_landing'] . 'carousel/';//\Yii::$app->params['staticHostInfo'] . '/files/images/landing/carousel/'; //перенести куда нить в параметры
        //scr::p($path);
        $list = scandir($path);
        $images = [];
        foreach ($list as $item) {
            if ($item == '.' || $item == '..') continue;
                $images[] = $url . $item;
        }
        \Yii::$app->response->headers->set('Cache-Control', 'public, max-age=' . 60 * 60 * 24 * 7);

        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $_SERVER['REMOTE_ADDR'] . '?lang=ru'));
        $region = $query['region'] == 'KGD' ? 'MOW' : 'KGD';

        return $this->render($mobile ? 'index_mobile' : 'index', [
            'images' => $images,
            'user' => $this->loginService->user(),
            'region' => $region,
        ]);
     // }

       // return $this->redirect(['/tours']);
    }

    public function actionUpdate()
    {
        $this->layout ='main-update';
        return $this->render('update', []);
    }


}
