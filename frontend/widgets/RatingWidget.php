<?php


namespace frontend\widgets;


use yii\base\Widget;

class RatingWidget extends Widget
{
    public $rating;

    public function run()
    {
        return $this->render('rating', [
            'rating' => $this->rating
        ]);
    }

}