<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnFind extends Widget
{
    public $not_caption;
    public function run()
    {
        return $this->render('btn-find',[
            'not_caption'=> $this->not_caption
        ]);
    }
}
