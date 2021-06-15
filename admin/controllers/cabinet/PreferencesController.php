<?php


namespace admin\controllers\cabinet;


use booking\entities\admin\User;
use booking\services\admin\UserManageService;
use booking\services\system\LoginService;
use yii\filters\AccessControl;
use yii\web\Controller;

class PreferencesController extends Controller
{
    public $layout = 'main-cabinet';
    /**
     * @var UserManageService
     */
    private $service;
    private $user_id;

    public function __construct($id, $module, UserManageService $service, LoginService $loginService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->user_id = $loginService->admin() ? $loginService->admin()->getId() : null;
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

    public function actionViewCancel()
    {
        if (\Yii::$app->request->isAjax) {
            $view_cancel = \Yii::$app->request->bodyParams['view_cancel'] ?? true;

            $user = $this->findModel();
            $preferences = $user->preferences;
            $preferences->view_cancel = $view_cancel;
            $user->UpdatePreferences($preferences);
            $user->save($user);
        }
    }

    public function actionDaysReview()
    {
        if (\Yii::$app->request->isAjax) {
            $days_review = \Yii::$app->request->bodyParams['days_review'] ?? true;

            $user = $this->findModel();
            $preferences = $user->preferences;
            $preferences->days_review = $days_review;
            $user->UpdatePreferences($preferences);
            $user->save($user);
        }
    }

    public function actionSetParams()
    {
        if (\Yii::$app->request->isAjax) {
            if (!isset(\Yii::$app->request->bodyParams['name_params']) || !isset(\Yii::$app->request->bodyParams['value_params'])) return 'Неверный параметр';
            $name_params = \Yii::$app->request->bodyParams['name_params'];
            $value_params = \Yii::$app->request->bodyParams['value_params'];
            $user = $this->findModel();
            try {
                $preferences = $user->preferences;
                $preferences->$name_params = $value_params;
                $user->UpdatePreferences($preferences);
                $user->save($user);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return '';
    }

    /*
     * $.post('/cabinet/preferences/set-params', {name_params: "__", value_params: "__"}, function(data) {})
     *
     */

    private function findModel()
    {
        return User::findOne($this->user_id);
    }
}