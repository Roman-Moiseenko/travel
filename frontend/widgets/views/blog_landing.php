<?php

use booking\entities\blog\post\Post;
use booking\helpers\SysHelper;
use yii\helpers\Url;

/* @var $posts Post[] */

$count = SysHelper::isMobile() ? 2 : 4;
$script = <<<JS
$(document).ready(function() {
        var swiper2 = new Swiper('.swiper2',{
          //  el: '.swiper-container',
            initialSlide: 2,
            spaceBetween: 10,
            slidesPerView: $count,
            loop: true,
            centeredSlides: true,
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
?>

<?php  if (SysHelper::isMobile()) echo '<p class="p-1"></p>';?>
<div class="swiper-container swiper2">
    <!-- Add Pagination -->
    <div class="swiper-pagination swiper-pagination2"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-wrapper">
        <?php foreach ($posts as $post): ?>
            <div class="swiper-slide text-center">
                <div class="card text-white shadow-lg" style="border: 0 !important; ">
                    <div class="item-responsive item-0-75by1">
                        <div class="content-item">
                            <img loading="lazy" src="<?= $post->getThumbFileUrl('photo', 'landing_list') ?>" class="card-img" alt="<?= $post->getTitle()?>">
                        </div>
                    </div>
                    <div class="card-img-overlay d-flex flex-column">
                        <div class="mt-auto">
                            <h4 class="card-title"
                                style="color: white; text-shadow: black 2px 2px 1px"><?= $post->getTitle() ?></h4>
                        </div>
                    </div>
                    <a href="<?= Url::to(['/post/view', 'id' => $post->id]) ?>" class="stretched-link"></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>