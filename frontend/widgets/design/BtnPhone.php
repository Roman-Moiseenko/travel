<?php


namespace frontend\widgets\design;


use booking\entities\ClickStruct;
use booking\entities\Lang;
use yii\base\Widget;

class BtnPhone extends Widget
{
    public $phone;
    public $caption;
    public $block = true;
    public $class_name = 'd2-btn-phone';
    public $class_name_click = '';
    public $class_id_click = 0;

    public function run()
    {

        return $this->render('btn-phone',[
            'phone'=> $this->phone,
            'caption' => $this->caption,
            'block' => $this->block,
            'class' => $this->class_name,
            'class_name_click' => $this->class_name_click,
            'class_id_click' => $this->class_id_click,
        ]);
    }
}
