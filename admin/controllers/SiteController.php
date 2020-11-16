<?php

namespace admin\controllers;


use admin\forms\DiscountSearch;
use admin\forms\TourSearch;
use booking\repositories\booking\DiscountRepository;
use booking\services\admin\UserManageService;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout = 'main-login';
    /**
     * @var DiscountRepository
     */
    private $discounts;
    /**
     * @var UserManageService
     */
    private $service;

    public function __construct($id, $module, DiscountRepository $discounts, UserManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->discounts = $discounts;
        $this->service = $service;
    }

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
                        'actions' => ['update'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index'],
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
        $this->layout = 'main';
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(Url::to(['/login']));
        }

        return $this->render('index');
    }

    public function actionUpdate()
    {
        $this->layout ='main-update';
        return $this->render('update', []);
    }


}
