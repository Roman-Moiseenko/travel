<?php

namespace frontend\widgets\menu;

use booking\repositories\moving\PageRepository;
use booking\services\system\LoginService;
use yii\base\Widget;

class ArtMenuWidget extends Widget
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

        return $this->render('art_menu', [
            //'categories' => $categories,
            'user' => $this->loginService->user(),
        ]);
    }
}