<?php


namespace frontend\widgets\templates;


use yii\base\Widget;

class HelperWidget extends Widget
{
    public $title;
    public $youtube;
    public $link;

    public function run()
    {
        return $this->render('helper', [
            'title' => $this->title,
            'youtube' => $this->youtube,
            'link' => $this->link,
        ]);
    }
}