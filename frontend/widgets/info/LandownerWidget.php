<?php


namespace frontend\widgets\info;


use yii\base\Widget;

class LandownerWidget extends Widget
{
    public function run()
    {
        return $this->render('landowner', [
        ]);
    }
}