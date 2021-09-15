<?php


/* @var $this \yii\web\View */

use booking\entities\booking\BaseReview;
use booking\helpers\scr;
use booking\helpers\SysHelper;
use frontend\assets\SwiperAsset;
use frontend\widgets\RatingWidget;
use yii\helpers\Url;
use yii\web\JqueryAsset;

/* @var $reviews BaseReview[] */
$count = SysHelper::isMobile() ? 2 : 4;
$script = <<<JS
$(document).ready(function() {
        var swiper2 = new Swiper('.swiper_review',{
          //  el: '.swiper-container',
            initialSlide: 2,
            spaceBetween: 30,
            slidesPerView: $count,
            loop: true,
            centeredSlides: false,
           // slideToClickedSlide: true,
          //  grabCursor: true,
            /*autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },*/

          /*  mousewheel: {
              enabled: true,
            },*/
         /*       pagination: {
        el: '.swiper-pagination2',
        clickable: true,
      },*/
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
        });
});
JS;
$this->registerJs($script);
JqueryAsset::register($this);
SwiperAsset::register($this);
?>

<h2 class="pt-4">Отзывы туристов</h2>

<?php  if (SysHelper::isMobile()) echo '<p class="p-1"></p>';?>
<div class="pt-3 swiper-container swiper_review">
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-wrapper">
        <?php foreach ($reviews as $review): ?>
            <div class="swiper-slide">
                <div class="card pl-4" style="border: 0 !important; ">
                    <div class="row">
                        <div class="d-flex flex-row">
                            <div class="">
                                <img src="<?= $review->user->personal->photo
                                    ? $review->user->personal->getThumbFileUrl('photo', 'forum_mobile')
                                    : Url::to('@static/files/images/no_user.png'); ?>"
                                     alt="<?= $review->user->personal->fullname->getFullname() ?>"
                                     style="border-radius: 12px; max-width: 60px; max-height: 60px"/>
                            </div>
                            <div  class="flex-grow-1 align-self-center pl-4">
                                <div style="font-size: 14px; font-weight: 600">
                                <?= $review->user->personal->fullname->getEuropeName() ?>
                                </div>

                                    <div>
                                    <?= RatingWidget::widget(['rating' => $review->vote, 'size' => 8])?>
                                    </div>
                                    <div><?= date('d-m-Y', $review->created_at)?></div>

                            </div>

                        </div>
                    </div>
                    <div class="pt-3"><?= $review->text ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>



