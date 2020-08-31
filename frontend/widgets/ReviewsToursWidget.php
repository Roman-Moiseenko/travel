<?php


namespace frontend\widgets;


use yii\base\Widget;

class ReviewsToursWidget extends Widget
{

    public $tours;

//TODO сДЕЛАТЬ Подгрузку отзывов
    public function run()
    {
        $reviews = $this->tours->reviews;

        return $this->render('review_tour', [
            'reviews' => $reviews,
        ]);
    }
}