<?php


namespace frontend\widgets\info;


use yii\base\Widget;

class BrokerLandownerWidget extends Widget
{
    public function run()
    {
        return $this->render('broker_landowner', [
        ]);
    }
}