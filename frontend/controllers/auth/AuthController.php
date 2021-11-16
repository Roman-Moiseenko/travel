<?php


namespace frontend\controllers\auth;

use booking\forms\auth\LoginForm;
use booking\services\system\LoginService;
use booking\services\user\AuthService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class   AuthController extends Controller
{
    public  $layout = 'blank';
    /**
     * @var AuthService
     */

    private  $authService;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct($id, $module, AuthService $authService, LoginService $loginService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
        $this->loginService = $loginService;
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
                        'roles' => ['?'],
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





    public function actionLogin()
    {
        if (!$this->loginService->isGuest()) {
            return $this->goHome();
        }

        $form = new LoginForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->authService->auth($form);
                \Yii::$app->user->login($user, ($form->rememberMe == '1') ? 3600 * 24 * 30 : 0);

                $session = \Yii::$app->session;
                if ($session->isActive) {
                    $link = $session->get('link');
                    $session->remove('link');
                    if ($link) return $this->redirect([$link]);
                }

                return $this->goBack();
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $form->password = '';
        $this->layout = 'blank';
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
        return $this->redirect(\Yii::$app->request->referrer);
        //return $this->goHome();
    }

}