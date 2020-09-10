<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\entities\user\User;
use booking\forms\admin\PersonalForm;
use booking\services\manage\UserManageService;
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
        $user = \Yii::$app->user->identity;
        return $this->render('index', [
            'user' => $user,
        ]);
    }

    public function actionUpdate()
    {
        $user = \Yii::$app->user->identity;
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

}