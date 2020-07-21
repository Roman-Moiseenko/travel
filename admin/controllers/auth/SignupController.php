<?php


namespace admin\controllers\auth;

use booking\forms\admin\SignupForm;
use booking\services\admin\SignupService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SignupController extends Controller
{
    public  $layout = 'main-login';
    /**
     * @var SignupService
     */
    private  $signupService;

    public function __construct($id, $module, SignupService $signupService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->signupService = $signupService;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user = $this->signupService->signup($form);
            if (\Yii::$app->getUser()->login($user)) {
                \Yii::$app->session->setFlash('success', 'Для входа на сайт Подтвердите свой email. Письмо с подтверждением было отправленно Вам на почту!');
                return $this->goHome();
            }
        }
        return $this->render('signup', [
            'model' => $form,
        ]);
    }
}