<?php


namespace frontend\widgets\reviews;

use frontend\widgets\RatingWidget;
use yii\base\Widget;

class ReviewsMovingWidget extends Widget
{
    public $reviews = [];
    public function run()
    {
        if (count($this->reviews) == 0) return;
        return $this->render('review_moving', [
            'reviews' => $this->reviews
        ]);
    }
}