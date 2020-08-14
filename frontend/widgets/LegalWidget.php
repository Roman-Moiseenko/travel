<?php


namespace frontend\widgets;


use yii\base\Widget;

class LegalWidget extends Widget
{
    public $legal;

    public function run()
    {
        return $this->render('legal', [
            'legal' => $this->legal,
        ]);
    }
}