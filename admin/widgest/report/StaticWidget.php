<?php


namespace admin\widgest\report;


use yii\base\Widget;

class StaticWidget extends Widget
{

    public $object;

    public function run()
    {

        return $this->render('static', [
        ]);
    }
}