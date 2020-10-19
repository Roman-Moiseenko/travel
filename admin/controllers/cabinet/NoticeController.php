<?php


namespace admin\controllers\cabinet;


use booking\entities\admin\User;
use booking\forms\admin\NoticeForm;
use booking\helpers\scr;
use booking\services\admin\UserManageService;
use booking\sms\sms;
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

        return $this->render('notice', [
            'notice' => $user->notice,
        ]);
    }

    public function actionAjax()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $item = $params['item'];
            $field = $params['field'];
            $value = (bool)$params['set'];
            $user = $this->findModel();
            $notice = $user->notice;
            $notice->$item->$field = $value;
            $user->updateNotice($notice);
            $user->save($user);
        }
    }

    private function findModel()
    {
        return User::findOne(\Yii::$app->user->id);
    }

    public function actionSend()
    {
        //sms::send('+79118589719', 'koenigs.ru');
        return $this->redirect(\Yii::$app->request->referrer);
    }
}