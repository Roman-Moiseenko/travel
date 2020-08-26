<?php


namespace admin\controllers\cabinet;


use booking\entities\admin\user\User;
use booking\forms\admin\NoticeForm;
use booking\helpers\scr;
use booking\services\admin\UserManageService;
use yii\filters\AccessControl;
use yii\web\Controller;

class NoticeController extends Controller
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
        $form = new NoticeForm($user->notice);
        //scr::p(\Yii::$app->request->post());
        if ($form->load(\Yii::$app->request->post()) /*&& $form->validate()*/) {
            try {
                scr::p($form->review);
                $this->service->setNotice($user->id, $form);
                return $this->redirect(['/cabinet/notice']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('notice', [
            'notice' => $user->notice,
            'model' => $form,
        ]);
    }

    private function findModel()
    {
        return User::findOne(\Yii::$app->user->id);
    }
}