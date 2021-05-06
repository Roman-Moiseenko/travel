<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnHistory extends Widget
{
    public $url;

    public function run()
    {
        return $this->render('btn-history',[
            'url'=> $this->url,
        ]);
    }
}
