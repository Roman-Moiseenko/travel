<?php


namespace office\controllers;


use booking\forms\auth\LoginForm;
use booking\services\office\AuthService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

class  AuthController extends Controller
{
    public  $layout = 'main-login';
    /**
     * @var AuthService
     */

    private  $authService;

    public function __construct($id, $module, AuthService $authService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'login'],
                'rules' => [

                   'logout' => [
                       'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                       ],
                    'login' => [
                        'actions' => ['login'],
                        'allow' => true,
                       // 'roles' => ['?'],
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
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
           return $this->goHome();
        }

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->authService->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0);
                return $this->redirect(['/']);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $form->password = '';
        return $this->render('login', ['model' => $form]);

    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect( Url::to(['/login']));
    }

}