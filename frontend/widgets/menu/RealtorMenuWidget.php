<?php

namespace frontend\widgets\menu;

use booking\services\system\LoginService;
use yii\base\Widget;

class RealtorMenuWidget extends Widget
{

    public function run()
    {
        return $this->render('realtor_menu', [
        ]);
    }
}