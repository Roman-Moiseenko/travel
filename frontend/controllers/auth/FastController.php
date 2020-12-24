<?php


namespace frontend\controllers\auth;


use booking\entities\Lang;
use booking\forms\auth\LoginForm;
use booking\forms\user\FastSignUpForm;
use booking\services\user\AuthService;
use booking\services\user\SignupService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class FastController extends Controller
{
    public $layout = 'blank';

    private $authService;
    private $signupService;

    public function __construct($id, $module, AuthService $authService, SignupService $signupService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
        $this->signupService = $signupService;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['sign-up'],
                'rules' => [
                    'login' => [
                        'actions' => ['sign-up'],
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

    public function actionSignUp()
    {
        $session = \Yii::$app->session;
        $link = $session->get('link');
        if ($link == null) throw new \DomainException('Доступ ограничен');
        $form = new FastSignUpForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->signupService->signup($form->signup);

                $user->personal->fullname->surname = $form->fullname->surname;
                $user->personal->fullname->firstname = $form->fullname->firstname;
                $user->personal->fullname->secondname = $form->fullname->secondname;
                $user->personal->phone = $form->phone;
                $user->personal->agreement = $form->agreement;
                $user->save();

                if (\Yii::$app->getUser()->login($user)) {
                    \Yii::$app->session->setFlash('success', Lang::t('Вы зарегистрировались. Для входа на сайт используйте логин или электронную почту'));
                    $session->remove('link');
                    return $this->redirect([$link]);
                }
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('signup', [
            'model' => $form,
        ]);
    }
}