<?php


namespace frontend\widgets\reviews;

use frontend\widgets\RatingWidget;
use yii\base\Widget;

class CommentWidget extends Widget
{
    public $reviews = [];
    public function run()
    {
        if (count($this->reviews) == 0) return;
        return $this->render('comments', [
            'reviews' => $this->reviews
        ]);
    }
}