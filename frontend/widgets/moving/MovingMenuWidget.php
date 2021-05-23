<?php

namespace frontend\widgets\moving;

use yii\base\Widget;

class MovingMenuWidget extends Widget
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function run()
    {
        return $this->render('moving-menu', [
        ]);
    }
}