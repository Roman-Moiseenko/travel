<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnEdit extends Widget
{
    public $url;
    public $caption = 'Редактировать';

    public function run()
    {
        return $this->render('btn-edit',[
            'url'=> $this->url,
            'caption' => $this->caption,
        ]);
    }
}
