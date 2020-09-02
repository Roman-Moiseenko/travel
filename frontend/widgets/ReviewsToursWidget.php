<?php


namespace frontend\widgets;


use yii\base\Widget;

class ReviewsToursWidget extends Widget
{
    public $tours;

    public function run()
    {
        $reviews = $this->tours->reviews;
        if (count($reviews) == 0) return;
        $array = [];
        foreach ($reviews as $review) {
            $vote = RatingWidget::widget(['rating' => $review->vote]);
            $fullname = $review->user->personal->fullname->getFullname();
            $date = date('d-m-Y', $review->created_at);
            $text = $review->text;
            $array[] = <<<HTML
<div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    $vote
                                </div>
                                <div class="select-text">
                                     $fullname
                                </div>
                                <div class="ml-auto">
                                    $date
                                </div>
                            </div>
                            <hr/>
                            <div class="p-3">
                                $text
                            </div>
                        </div>
                    </div>
HTML;
        }
        return $this->render('review_tour', [
            'array' => json_encode($array)
        ]);
    }
}