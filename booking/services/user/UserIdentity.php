<?php


namespace booking\services\user;


use yii\helpers\Json;
use yii\web\Cookie;

class UserIdentity
{
    private $key;
    private $timeout;

    public function __construct($key, $timeout)
    {
        $this->key = $key;
        $this->timeout = $timeout;
    }

    public function loadUser():? string
    {
        return \Yii::$app->request->cookies->get($this->key);
    }

    public function createUser(): string
    {
        $user_cookie = uniqid('', true);
        \Yii::$app->response->cookies->add(new Cookie([
            'name' => $this->key,
            'value' => $user_cookie,
            'expire' => time() + $this->timeout,
        ]));
        return $user_cookie;
    }
}