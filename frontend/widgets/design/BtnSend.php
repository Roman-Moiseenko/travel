<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnSend extends Widget
{
    public $caption;

    public function run()
    {
        return $this->render('btn-send',[
            'caption' => $this->caption,
        ]);
    }
}

