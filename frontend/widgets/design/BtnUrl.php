<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnUrl extends Widget
{
    public $url;
    public $caption;
    public $block = true;
    public $class_name_click = '';
    public $class_id_click = 0;


    public function run()
    {
        return $this->render('btn-url',[
            'url'=> $this->url,
            'caption' => $this->caption,
            'block' => $this->block,
            'class_name_click' => $this->class_name_click,
            'class_id_click' => $this->class_id_click,
        ]);
    }
}
