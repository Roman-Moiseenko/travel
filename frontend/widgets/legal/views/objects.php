<?php

/* @var $objects array */
$script = <<<JS
$(document).ready(function() {
        var swiper2 = new Swiper('.swiper2',{
          //  el: '.swiper-container',
            initialSlide: 2,
            spaceBetween: 10,
            slidesPerView: 3,
            loop: true,
            centeredSlides: true,
           // slideToClickedSlide: true,
          //  grabCursor: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },

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

<div class="swiper-container swiper2">
    <!-- Add Pagination -->
    <div class="swiper-pagination swiper-pagination2"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-wrapper">
        <?php foreach ($objects as $object): ?>
            <div class="swiper-slide text-center">

                <div class="card">
                    <div class="card-body">

                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</div>