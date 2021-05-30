<?php

namespace frontend\widgets;

use booking\services\system\LoginService;
use yii\base\Widget;

class TopmenuWidget extends Widget
{
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(LoginService $loginService, $config = [])
    {
        parent::__construct($config);
        $this->loginService = $loginService;
    }

    public function run()
    {
        return $this->render('topmenu', [
            'user' => $this->loginService->user()
        ]);
    }
}