<?php

namespace frontend\widgets\menu;

use booking\services\system\LoginService;
use yii\base\Widget;

class LandMenuWidget extends Widget
{

    public function run()
    {
        return $this->render('land_menu', [
        ]);
    }
}