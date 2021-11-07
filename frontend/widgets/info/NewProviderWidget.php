<?php


namespace frontend\widgets\info;


use yii\base\Widget;

class NewProviderWidget extends Widget
{
    public function run()
    {
        return $this->render('new_provider', [
        ]);
    }

}