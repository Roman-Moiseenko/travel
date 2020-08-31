<?php

use yii\helpers\Url;

$js=<<<JS
    $('#slideshow0').swiper({
        mode: 'horizontal',
        slidesPerView: 1,
        pagination: '.slideshow0',
        paginationClickable: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        spaceBetween: 30,
        autoplay: 2500,
        autoplayDisableOnInteraction: true,
        loop: true
    });
JS;
$this->registerJs($js);
?>

<div class="swiper-viewport">
    <div id="slideshow0" class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($reviews as $review): ?>
                <div class="swiper-slide text-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <?= \frontend\widgets\RatingWidget::widget(['rating' => $review->vote]) ?>
                                </div>
                                <div class="ml-auto">
                                    Юзер
                                </div>
                                <div class="pl-2">
                                    <?= date('d-m-Y', $review->created_at) ?>
                                </div>
                            </div>
                            <div>
                                <?= $review->text ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="swiper-pagination slideshow0"></div>
    <div class="swiper-pager">
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

