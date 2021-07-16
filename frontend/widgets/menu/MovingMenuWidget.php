<?php

namespace frontend\widgets\menu;

use booking\repositories\moving\PageRepository;
use booking\services\system\LoginService;
use yii\base\Widget;

class MovingMenuWidget extends Widget
{
    /**
     * @var LoginService
     */
    private $loginService;
    /**
     * @var PageRepository
     */
    private $pages;

    public function __construct(LoginService $loginService, PageRepository $pages, $config = [])
    {
        parent::__construct($config);
        $this->loginService = $loginService;
        $this->pages = $pages;
    }

    public function run()
    {
        $categories = $this->pages->findRoot();
        return $this->render('moving_menu', [
            'categories' => $categories,
            'user' => $this->loginService->user(),
        ]);
    }
}