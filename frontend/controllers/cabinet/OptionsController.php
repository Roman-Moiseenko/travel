<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\entities\user\User;
use booking\forms\user\PreferencesForm;
use booking\helpers\scr;
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

    public function __construct($id, $module, UserManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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
        $user = \Yii::$app->user->identity;
        $form = new PreferencesForm($user->preferences, $user->mailing);
        if ($form->load(\Yii::$app->request->post())) {
            try {
                $this->service->setPreferences($user->id, $form);
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