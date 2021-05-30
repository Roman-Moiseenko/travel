<?php


namespace frontend\widgets;


use booking\helpers\scr;
use booking\services\system\LoginService;
use yii\base\Widget;

class UserMenuWidget extends Widget
{
    const TOP_USERMENU = 1;
    const CABINET_USERMENU = 2;
    public $type;
    public $class_list;
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
        if ($this->loginService->isGuest()) {
            return $this->render('guestmenu');
        }
        return $this->render('usermenu', [
            'type' =>$this->type,
            'class' =>$this->class_list,
        ]);
    }
}