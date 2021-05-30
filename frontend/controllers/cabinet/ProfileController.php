<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\entities\user\User;
use booking\forms\user\PersonalForm;
use booking\services\system\LoginService;
use booking\services\user\UserManageService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
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
        return $this->render('index', [
            'user' => $this->loginService->user(),
        ]);
    }

    public function actionUpdate()
    {
        $user = $this->loginService->user();
        $form = new PersonalForm($user->personal);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setPersonal($user->getId(), $form);
                return $this->redirect(['/cabinet/profile']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
                $form = new PersonalForm($user->personal);//Страный глюк с катриком
            }
        }
        return $this->render('update', [
            'user' => $user,
            'model' => $form,
        ]);
    }

}