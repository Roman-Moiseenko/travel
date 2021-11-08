<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnPhone extends Widget
{
    public $phone;
    public $caption;
    public $block = true;

    public function run()
    {
        return $this->render('btn-phone',[
            'phone'=> $this->phone,
            'caption' => $this->caption,
            'block' => $this->block,

        ]);
    }
}
