<?php

namespace frontend\widgets\menu;

use booking\services\system\LoginService;
use yii\base\Widget;

class BookingMenuWidget extends Widget
{
    public function run()
    {
        return $this->render('booking_menu', [
        ]);
    }
}