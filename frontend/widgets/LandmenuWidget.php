<?php

namespace frontend\widgets;

use booking\services\system\LoginService;
use yii\base\Widget;

class LandmenuWidget extends Widget
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
        return $this->render('landmenu', [
            'user' => $this->loginService->user()
        ]);
    }
}