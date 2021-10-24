<?php

namespace frontend\widgets\menu;

use booking\repositories\medicine\PageRepository;
use booking\services\system\LoginService;
use yii\base\Widget;

class MedicineMenuWidget extends Widget
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
        return $this->render('medicine_menu', [
            'categories' => $categories,
            'user' => $this->loginService->user(),
        ]);
    }
}