<?php


use yii\helpers\Html;
use yii\helpers\Url;
/* @var $reviews \booking\entities\booking\tours\ReviewTour[] */
?>

<div class="swiper-viewport">
    <div id="1slideshow0" class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($reviews as $review): ?>
                <div class="swiper-slide text-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <?= \frontend\widgets\RatingWidget::widget(['rating' => $review->vote]) ?>
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
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="1swiper-pagination 1slideshow0"></div>
    <div class="1swiper-pager">
        <div class="1swiper-button-next"></div>
        <div class="1swiper-button-prev"></div>
    </div>
</div>

