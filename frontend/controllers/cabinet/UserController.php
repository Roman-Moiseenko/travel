<?php


namespace frontend\controllers\cabinet;


use booking\helpers\UserHelper;
use booking\repositories\UserRepository;
use booking\services\manage\UserManageService;
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

    public function __construct($id, $module, UserManageService $service, UserRepository $users, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->users = $users;
    }

    public function actionLang($lang)
    {
        if (!in_array($lang, UserHelper::listLangs())) $lang = 'ru';
        if (\Yii::$app->user->isGuest)
        {
            \Yii::$app->response->cookies->add(new Cookie([
                'name' => 'lang',
                'value' => $lang,
                'expire' => time() + 3600 * 24 * 365
            ]));
        } else {
            // Сохраняем язык в базе пользователя
            $this->service->setLang(\Yii::$app->user->id, $lang);
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionCurrency($currency)
    {

        if (\Yii::$app->user->isGuest)
        {
            \Yii::$app->response->cookies->add(new Cookie([
                'name' => 'currency',
                'value' => $currency,
                'expire' => time() + 3600 * 24 * 365
            ]));
        } else {
            //Сохраняем валюту в базе пользователя
            $this->service->setCurrency(\Yii::$app->user->id, $currency);
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }
}