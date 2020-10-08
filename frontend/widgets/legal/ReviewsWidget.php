<?php


namespace frontend\widgets\legal;


use booking\helpers\scr;
use booking\repositories\booking\ReviewRepository;
use yii\base\Widget;

class ReviewsWidget extends Widget
{
    /**
     * @var ReviewRepository
     */
    private $reviews;
    public $legal_id;

    public function __construct(ReviewRepository $reviews, $config = [])
    {
        parent::__construct($config);
        $this->reviews = $reviews;
    }

    public function run()
    {
        $reviews = $this->reviews->getByLegal($this->legal_id);
        $votes = 0;
        foreach ($reviews as $review) {
            $votes += $review->getVote();
        }
        $rating = $votes / count($reviews);

        return $this->render('reviews', [
            'reviews' => $reviews,
            'rating' => $rating,
        ]);
    }
}