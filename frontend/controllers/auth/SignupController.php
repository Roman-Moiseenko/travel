<?php


namespace frontend\controllers\auth;


use booking\entities\Lang;
use booking\forms\user\SignupForm;
use booking\services\user\SignupService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SignupController extends Controller
{
    public  $layout = 'blank';
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
            try {
                $user = $this->signupService->signup($form);
                if (\Yii::$app->getUser()->login($user)) {
                    \Yii::$app->session->setFlash('success', Lang::t('Вы зарегистрировались. Для входа на сайт используйте номер телефона или электронную почту'));

                    $session = \Yii::$app->session;
                    if ($session->isActive) {
                        $link = $session->get('link');
                        $session->remove('link');
                        if ($link) return $this->redirect([$link]);
                    }
                    return $this->redirect(['/tours']);
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