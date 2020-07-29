<?php


namespace admin\controllers\cabinet;


use booking\entities\admin\user\User;
use booking\forms\admin\PersonalForm;
use booking\services\admin\UserManageService;
use booking\services\booking\tours\ToursService;

use yii\filters\AccessControl;
use yii\web\Controller;

class ProfileController extends Controller
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
        $form = new PersonalForm($user->personal);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setPersonal($user->id, $form);
                return $this->redirect(['/cabinet/profile']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'user' => $user,
            'model' => $form,
        ]);
    }


    private function findModel()
    {
        return User::findOne(\Yii::$app->user->id);
    }
}