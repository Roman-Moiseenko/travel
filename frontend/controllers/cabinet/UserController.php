<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\helpers\UserHelper;
use booking\repositories\user\UserRepository;
use booking\services\system\LoginService;
use booking\services\user\UserManageService;
use yii\web\Controller;
use yii\web\Cookie;

class UserController extends Controller
{
    /**
     * @var UserManageService
     */
    private $service;
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        $id,
        $module,
        UserManageService $service,
        UserRepository $users,
        LoginService $loginService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->users = $users;
        $this->loginService = $loginService;
    }

    public function actionLang($lang)
    {

    }

    public function actionCurrency($currency)
    {

        if ($this->loginService->isGuest())
        {
            \Yii::$app->response->cookies->add(new Cookie([
                'name' => 'currency',
                'value' => $currency,
                'expire' => time() + 3600 * 24 * 365
            ]));
        } else {
            //Сохраняем валюту в базе пользователя
            $this->service->setCurrency($this->loginService->user()->getId(), $currency);
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionSmocking($smocking)
    {

    }

}