<?php

namespace check\controllers;


use booking\entities\check\User;
use booking\helpers\scr;
use booking\services\check\UserManageService;
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
                    //    'roles' => ['@'],
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
        $user = $this->loginService->check();
        if (count($user->objects) == 1) {
            return $this->redirect(['give/view', 'id' => $user->objects[0]->id]);
        }
        return $this->redirect(Url::to(['give/index']));
    }

    public function actionUpdate()
    {
        $this->layout ='main-update';
        return $this->render('update', []);
    }
}
