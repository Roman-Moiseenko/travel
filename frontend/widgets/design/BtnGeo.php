<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnGeo extends Widget
{
    public $caption;
    public $target_id;

    public function run()
    {
        return $this->render('btn-geo',[
            'caption'=> $this->caption,
            'target_id' => $this->target_id,
        ]);
    }
}
