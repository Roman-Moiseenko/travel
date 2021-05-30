<?php


namespace office\widgets;

use booking\services\system\LoginService;
use yii\base\Widget;


class SupportMessageTopBarWidget extends Widget
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
        if ($this->loginService->isGuest()) return '';

        return $this->render('message_top_bar', [

        ]);
    }
}