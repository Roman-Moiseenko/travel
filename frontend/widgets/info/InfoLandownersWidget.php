<?php


namespace frontend\widgets\info;


use yii\base\Widget;

class InfoLandownersWidget extends Widget
{
    public function run()
    {
        return $this->render('info_landowners', [
        ]);
    }
}