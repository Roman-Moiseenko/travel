<?php

/* @var $objects array */

use booking\helpers\SysHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$count = SysHelper::isMobile() ? 2 : 4;
$script = <<<JS
$(document).ready(function() {
        var swiper2 = new Swiper('.swiper2',{
          //  el: '.swiper-container',
            initialSlide: 1,
            spaceBetween: 10,
            slidesPerView: $count,
          //  loop: true,
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

      pagination: {
        el: '.swiper-pagination2',
        clickable: true,
      },
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
        });
});
JS;
$this->registerJs($script)
?>
<?php  if (SysHelper::isMobile()) echo '<p class="p-1"></p>';?>
<div class="swiper-container swiper2">
    <!-- Add Pagination -->
    <div class="swiper-pagination swiper-pagination2"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-wrapper">
        <?php foreach ($objects as $object): ?>
            <div class="swiper-slide text-center">

                <div class="card text-white shadow-lg" style="border: 0 !important; ">
                    <img src="<?= $object['photo'] ?>" class="card-img">
                    <div class="card-img-overlay">
                        <h3 class="card-title"
                            style="color: white; text-shadow: black 2px 2px 1px"><?= $object['name'] ?></h3>
                        <!--p class="card-text pt-4"><?= StringHelper::truncateWords(strip_tags($object['description']), 20) ?></p-->
                    </div>
                    <a href="<?= $object['link'] ?>" class="stretched-link"></a>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>