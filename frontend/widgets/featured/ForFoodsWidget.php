<?php


namespace frontend\widgets\featured;


use booking\entities\booking\tours\Tour;
use yii\base\Widget;

class ForFoodsWidget extends Widget
{
    public function run()
    {
        $tours = Tour::find()->active()->all();

        $tour = $tours[rand(0, count($tours) - 1)];
        return $this->render('for-foods', [
            'tour' => $tour,
        ]);
    }
}