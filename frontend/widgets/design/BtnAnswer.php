<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnAnswer extends Widget
{
    public $caption;
    public $id;
    public $target;

    public function run()
    {
        return $this->render('btn-answer',[
            'caption' => $this->caption,
            'id' => $this->id,
            'target' => $this->target,
        ]);
    }
}

