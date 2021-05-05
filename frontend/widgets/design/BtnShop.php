<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnShop extends Widget
{
    public $url;

    public function run()
    {
        return $this->render('btn-shop',[
            'url'=> $this->url,
        ]);
    }
}
