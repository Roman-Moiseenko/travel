<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnReview extends Widget
{
    public $caption;
    public $target_id;

    public function run()
    {
        return $this->render('btn-review',[
            'caption'=> $this->caption,
            'target_id' => $this->target_id,
        ]);
    }
}
