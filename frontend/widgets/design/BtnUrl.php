<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnUrl extends Widget
{
    public $url;
    public $caption;
    public $block = true;

    public function run()
    {
        return $this->render('btn-url',[
            'url'=> $this->url,
            'caption' => $this->caption,
            'block' => $this->block,

        ]);
    }
}
