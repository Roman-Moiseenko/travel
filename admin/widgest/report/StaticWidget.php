<?php


namespace admin\widgest\report;


use yii\base\Widget;

class StaticWidget extends Widget
{

    public $object;

    public function run()
    {
        $views = $this->object->views;
//TODO Стат данные по финансам объекта !!!!!!!!!!!
        return $this->render('static', [
            'views' => $views,
        ]);
    }
}