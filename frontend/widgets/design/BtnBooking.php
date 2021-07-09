<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnBooking extends Widget
{
    public $confirmation;
    public $caption;
    public $btn_id;
    public $block;

    public function run()
    {
        return $this->render('btn-booking',[
            'confirmation' => $this->confirmation,
            'caption' => $this->caption,
            'btn_id' => $this->btn_id,
            'block' => $this->block,
        ]);
    }
}
