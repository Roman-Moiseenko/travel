<?php

use booking\entities\booking\ReviewInterface;
use booking\entities\Lang;
use frontend\widgets\RatingWidget;


/* @var $reviews ReviewInterface[] */
/* @var $rating float */

$script = <<<JS
$(document).ready(function() {
        var swiper1 = new Swiper('.swiper1',{
          //  el: '.swiper-container',
            initialSlide: 2,
            spaceBetween: 10,
            slidesPerView: 1,
            loop: true,
            centeredSlides: true,
           // slideToClickedSlide: true,
          //  grabCursor: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },

          /*  mousewheel: {
              enabled: true,
            },*/
          
        });
});
JS;
$this->registerJs($script)
?>

<div class="pb-2">
    <?= Lang::t('Рейтинг по отзывам') ?>: <span class="badge badge-success" style="font-size: 16px"><?= number_format($rating, 2, '.', ' ') ?></span>
</div>

<div class="swiper-container swiper1">
    <div class="swiper-wrapper">
        <?php foreach ($reviews as $review): ?>
            <div class="swiper-slide text-center">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <?= RatingWidget::widget(['rating' => $review->vote]) ?>
                            </div>
                            <div class="select-text">
                                <?= $review->user->personal->fullname->getFullname() ?>
                            </div>
                            <div class="ml-auto">
                                <?= $date = date('d-m-Y', $review->created_at); ?>
                            </div>
                        </div>
                        <hr/>
                        <div class="p-3">
                            <?= $review->getText() ?>
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</div>