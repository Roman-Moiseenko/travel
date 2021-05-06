<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnWish extends Widget
{
    public $url;
    public function run()
    {
        return $this->render('btn-wish',[
            'url'=> $this->url,
        ]);
    }
}
