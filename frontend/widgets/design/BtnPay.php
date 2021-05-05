<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnPay extends Widget
{
    public $url;
    public $paid_locality = false;
    public function run()
    {
        return $this->render('btn-pay',[
            'url'=> $this->url,
            'paid_locality' => $this->paid_locality,
        ]);
    }
}
