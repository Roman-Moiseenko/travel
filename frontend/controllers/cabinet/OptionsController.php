<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\entities\user\User;
use booking\forms\user\PreferencesForm;
use booking\helpers\scr;
use booking\services\system\LoginService;
use booking\services\user\UserManageService;
use yii\filters\AccessControl;
use yii\web\Controller;

class OptionsController extends Controller
{
    public $layout = 'cabinet';
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

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        /** @var User $user */
        $user = $this->loginService->user();
        $form = new PreferencesForm($user->preferences, $user->mailing);
        if ($form->load(\Yii::$app->request->post())) {
            try {
                $this->service->setPreferences($user->getId(), $form);
                return $this->redirect(['/cabinet/options', 'lang' => $form->lang]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'user' => $user,
            'model' => $form,
        ]);
    }
}