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
        //$mobile = SysHelper::isMobile();
        $params = \Yii::$app->request->queryParams;
        $path = __DIR__ . '/../web/' . \Yii::$app->params['url_img_landing'] . 'carousel/';//\Yii::$app->params['staticPath'] . '/files/images/landing/carousel/'; //перенести куда нить в параметры
        $url = $url_img_booking = \Yii::$app->params['url_img_landing'] . 'carousel/';//\Yii::$app->params['staticHostInfo'] . '/files/images/landing/carousel/'; //перенести куда нить в параметры
        $list = scandir($path);
        $images = [];
        foreach ($list as $item) {
            if ($item == '.' || $item == '..') continue;
                $images[] = $url . $item;
        }
        \Yii::$app->response->headers->set('Cache-Control', 'public, max-age=' . 60 * 60 * 24 * 7);
        /*if (isset(\Yii::$app->params['locale'])) {
            $region = 'MOW';
        } else {
            $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $_SERVER['REMOTE_ADDR'] . '?lang=ru'));
            $region = $query['region'] == 'KGD' ? 'MOW' : 'KGD';
        }
        */
        $buttons = [
            [
                'url' => '/tours',
                'img_name' => 'tour',
                'img_alt' => 'Экскурсии в Калининграде',
                'caption' => 'Экскурсии',
            ],
            [
                'url' => '/funs',
                'img_name' => 'fun',
                'img_alt' => 'Развлечения и отдых в Калининграде',
                'caption' => 'Развлечения<br>Отдых',
            ],
            [
                'url' => '/stays',
                'img_name' => 'stay',
                'img_alt' => 'Проживание Калининграде',
                'caption' => 'Проживание',
            ],
            [
                'url' => '/cars',
                'img_name' => 'car',
                'img_alt' => 'Прокат авто в Калининграде',
                'caption' => 'Прокат авто',
            ],
            [
                'url' => '/medicine',
                'img_name' => 'medicine',
                'img_alt' => 'Медицинский туризм в Калининграде',
                'caption' => 'Медицинский<br>туризм',
            ],
            [
                'url' => '/moving',
                'img_name' => 'moving',
                'img_alt' => 'На ПМЖ в Калининграде',
                'caption' => 'На ПМЖ',
            ],
            [
                'url' => '/realtor',
                'img_name' => 'land',
                'img_alt' => 'Купить-продать землю и недвижимость в Калининграде',
                'caption' => 'Земельные участки',
            ],
            [
                'url' => '/forum',
                'img_name' => 'forum',
                'img_alt' => 'Форум в Калининграде',
                'caption' => 'Форумы<br><br>На ПМЖ<br>Лечение<br>Туристам',
            ],
            [
                'url' => '/night',
                'img_name' => 'night',
                'img_alt' => 'Ночная жизнь в Калининграде',
                'caption' => 'Ночная жизнь<br>Развлечения<br>Отдых',
            ],
            [
                'url' => '/foods',
                'img_name' => 'food',
                'img_alt' => 'Где поесть в Калининграде',
                'caption' => 'Где поесть',
            ],
            [
                'url' => '/shops',
                'img_name' => 'shop',
                'img_alt' => 'Что купить в Калининграде',
                'caption' => 'Сувениры',
            ],
            [
                'url' => '/post',
                'img_name' => 'blog',
                'img_alt' => 'Туристам о Калининграде',
                'caption' => 'Туристам о Калининграде',
            ]
        ];
        return $this->render(/*$mobile ? 'index_mobile' : */'index', [
            'images' => $images,
            'user' => $this->loginService->user(),
            'buttons' => $buttons,
        ]);
    }

    public function actionUpdate()
    {
        $this->layout ='main-update';
        return $this->render('update', []);
    }

    public function actionAvia()
    {

        if (isset(\Yii::$app->params['locale'])) {
            $region = 'MOW';
        } else {
            $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $_SERVER['REMOTE_ADDR'] . '?lang=ru'));
            $region = $query['region'] == 'KGD' ? 'MOW' : 'KGD';
        }

        return $this->render('avia', [
            'user' => $this->loginService->user(),
            'region' => $region,
        ]);
    }


}
