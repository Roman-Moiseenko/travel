<?php

use booking\entities\booking\BaseReview;
use frontend\widgets\RatingWidget;

/* @var $array array */
/* @var $reviews BaseReview[] */
?>
<?php foreach ($reviews as $review): ?>
    <div class="card pt-2" style="border-radius: 20px">
        <div class="card-body">
            <div class="d-flex">
                <div>
                    <?= RatingWidget::widget(['rating' => $review->vote]) ?>
                </div>
                <div class="select-text">
                    <?= $review->user->personal->fullname->getFullname() ?>
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
