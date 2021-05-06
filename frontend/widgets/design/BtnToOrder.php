<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnToOrder extends Widget
{
    public $url;

    public function run()
    {
        return $this->render('btn-to-order',[
            'url'=> $this->url,
        ]);
    }
}
