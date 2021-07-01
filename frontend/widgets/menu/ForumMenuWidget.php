<?php

namespace frontend\widgets\menu;

use booking\services\system\LoginService;
use yii\base\Widget;

class ForumMenuWidget extends Widget
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
        return $this->render('forum_menu', [
            'user' => $this->loginService->user(),
        ]);
    }
}