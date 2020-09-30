<?php


namespace office\widgets;

use yii\base\Widget;


class SupportMessageTopBarWidget extends Widget
{

    public function run()
    {
        if (\Yii::$app->user->isGuest) return '';

        return $this->render('message_top_bar', [

        ]);
    }
}