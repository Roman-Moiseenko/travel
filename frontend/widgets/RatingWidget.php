<?php


namespace frontend\widgets;


use yii\base\Widget;

class RatingWidget extends Widget
{
    public $rating;
    public $size = false;
    public function run()
    {
        return $this->render('rating', [
            'rating' => $this->rating,
            'size' => $this->size,
        ]);
    }

}