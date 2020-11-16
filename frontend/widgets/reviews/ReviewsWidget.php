<?php


namespace frontend\widgets\reviews;

use frontend\widgets\RatingWidget;
use yii\base\Widget;

class ReviewsWidget extends Widget
{
    public $reviews = [];
    public function run()
    {

        if (count($this->reviews) == 0) return;
        $array = [];
        foreach ($this->reviews as $review) {
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
        return $this->render('review', [
            'array' => json_encode($array)
        ]);
    }
}