<?php

use booking\entities\booking\BaseReview;
use booking\entities\foods\ReviewFood;
use frontend\widgets\RatingWidget;

/* @var $array array */
/* @var $reviews ReviewFood[] */
?>
<?php foreach ($reviews as $review): ?>
    <div class="card mt-2" style="border-radius: 20px">
        <div class="card-body">
            <div class="d-flex">
                <div>
                    <?= RatingWidget::widget(['rating' => $review->vote]) ?>
                </div>
                <div class="select-text">
                    <?= $review->username ?>
                </div>
                <div class="ml-auto">
                    <?= date('d-m-Y', $review->created_at) ?>
                </div>
            </div>
            <hr/>
            <div class="p-3">
                <?= $review->text ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
