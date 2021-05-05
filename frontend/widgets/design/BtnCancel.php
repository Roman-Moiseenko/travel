<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnCancel extends Widget
{
    public $url;
    public $caption = 'Отменить';

    public function run()
    {
        return $this->render('btn-cancel', [
            'url' => $this->url,
            'caption' => $this->caption,
        ]);
    }
}
