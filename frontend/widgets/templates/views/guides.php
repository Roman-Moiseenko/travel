<?php



/* @var $this \yii\web\View */

use booking\entities\admin\Legal;
use booking\entities\booking\tours\Tour;
use booking\helpers\scr;
use booking\helpers\SysHelper;
use frontend\assets\SwiperAsset;
use frontend\widgets\RatingWidget;
use yii\helpers\Url;
use yii\web\JqueryAsset;

/* @var $guides Legal[] */

$count = SysHelper::isMobile() ? 2 : 4;
$count = count($guides) < 4 ? 2 : 4;

$script = <<<JS
$(document).ready(function() {
        var swiper2 = new Swiper('.swiper_review',{
          //  el: '.swiper-container',
            initialSlide: 1,
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

<h2 class="pt-4">Наши гиды</h2>

<?php  if (SysHelper::isMobile()) echo '<p class="p-1"></p>';?>
    <div class="pt-3 swiper-container swiper_review">
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <!--div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div-->
        <div class="swiper-wrapper">
            <?php foreach ($guides as $guide): ?>
                <div class="swiper-slide">
                    <div class="card pl-4" style="border: 0 !important; ">


                                <div><a href="<?= Url::to(['/legals/view', 'id' => $guide->id])?>">
                                    <img src="<?= $guide->photo
                                        ? $guide->getThumbFileUrl('photo', 'cart_list')
                                        : Url::to('@static/files/images/no_user.png'); ?>"
                                         alt="<?= $guide->caption ?>"
                                         style="border-radius: 12px; max-width: 160px; max-height: 160px"/>
                                    </a>
                                </div>
                                <div  class="pt-4" style="font-size: 16px">
                                    <?= $guide->name ?>
                                </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
