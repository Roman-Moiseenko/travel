<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class smBtnPrint extends Widget
{
    public $url;
    public function run()
    {
        return $this->render('sm-btn-print',[
            'url'=> $this->url,
        ]);
    }
}
