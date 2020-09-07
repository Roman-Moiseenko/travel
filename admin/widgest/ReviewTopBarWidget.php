<?php


namespace admin\widgest;


use booking\repositories\booking\ReviewRepository;
use yii\base\Widget;

class ReviewTopBarWidget extends Widget
{
    private $reviews;
    public $days = 7;
    public function __construct(ReviewRepository $reviews, $config = [])
    {
        parent::__construct($config);
        $this->reviews = $reviews;
    }

    public function run()
    {
        $all_reviews = $this->reviews->getByAdmin(\Yii::$app->user->id, $this->days);
        $count = count($all_reviews);
        $reviews = array_slice($all_reviews, 0, ($count < 6) ? $count : 5);

        return $this->render('review_top_bar', [
            'reviews' => $reviews,
            'last_day' => $this->days,
            'count' => $count,
        ]);
    }
}