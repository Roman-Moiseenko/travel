<?php

namespace admin\controllers;


use admin\forms\TourSearch;

use booking\services\admin\UserManageService;
use booking\services\system\LoginService;
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
     * @var UserManageService
     */
    private $service;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct($id, $module, UserManageService $service, LoginService $loginService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->loginService = $loginService;
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
        if ($this->loginService->isGuest()) {
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
