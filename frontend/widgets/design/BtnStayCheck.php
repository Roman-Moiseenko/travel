<?php


namespace frontend\widgets\design;


use yii\base\Widget;

class BtnStayCheck extends Widget
{
    public $caption;
    public $url;

    public function run()
    {
        return $this->render('btn-stay-check',[
            'caption' => $this->caption,
            'url' => $this->url
        ]);
    }
}