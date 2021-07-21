<?php


namespace frontend\widgets\moving;


use booking\helpers\SysHelper;
use yii\base\Widget;

class MenuPagesWidget extends Widget
{
    public $pages;

    public function run()
    {
        $mobile = SysHelper::isMobile();
        return $this->render($mobile ? 'menu_pages_mobile' : 'menu_pages', [
            'pages' => $this->pages,
        ]);
    }
}