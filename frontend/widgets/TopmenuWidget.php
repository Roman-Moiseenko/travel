<?php


namespace frontend\widgets;


use yii\base\Widget;

class TopmenuWidget extends Widget
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function run()
    {
        return $this->render('topmenu', [
        ]);
    }
}