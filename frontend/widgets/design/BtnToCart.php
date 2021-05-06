<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnToCart extends Widget
{
    public $url;

    public function run()
    {
        return $this->render('btn-to-cart',[
            'url'=> $this->url,
        ]);
    }
}
