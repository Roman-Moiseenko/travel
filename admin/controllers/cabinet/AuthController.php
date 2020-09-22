<?php


namespace admin\controllers\cabinet;


use booking\entities\admin\User;
use booking\forms\admin\PasswordEditForm;
use booking\forms\admin\UserEditForm;
use booking\services\admin\UserManageService;
use yii\filters\AccessControl;
use yii\web\Controller;

class AuthController extends Controller
{
    public $layout = 'main-cabinet';
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
                        //   'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = $this->findModel();
        return $this->render('index', [
            'user' => $user,
        ]);
    }

    public function actionUpdate()
    {
        $user = $this->findModel();
        $form = new UserEditForm($user);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->update($user->id, $form);
                return $this->redirect(['/cabinet/auth']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    public function actionPassword()
    {
        $user = $this->findModel();
        $form = new PasswordEditForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->newPassword($user->id, $form);
                \Yii::$app->session->setFlash('success', 'Пароль успешно изменен.');
                return $this->redirect(['/cabinet/auth']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('password', [
            'model' => $form,
        ]);
    }

    private function findModel()
    {
        return User::findOne(\Yii::$app->user->id);
    }
}