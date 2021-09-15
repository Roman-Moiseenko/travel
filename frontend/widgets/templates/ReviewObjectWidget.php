<?php


namespace frontend\widgets\templates;


use booking\entities\booking\tours\ReviewTour;
use yii\base\Widget;

class ReviewObjectWidget extends Widget
{
    public $object;

    public function run()
    {
        $class = $this->object;
        //ReviewTour::find()->limit(4)->orderBy(['created_at' => SORT_DESC]);
        $reviews = $class::find()->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('review', [
            'reviews' => $reviews,
        ]);
    }
}