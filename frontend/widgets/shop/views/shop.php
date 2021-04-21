<?php



use booking\entities\shops\products\Product;
use booking\helpers\SysHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $products Product[] */
$count = SysHelper::isMobile() ? 2 : 6;
$script = <<<JS
$(document).ready(function() {
        var swiper2 = new Swiper('.swiper2',{
            initialSlide: 3,
            spaceBetween: 10,
            slidesPerView: $count,
            centeredSlides: true,
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
        <?php foreach ($products as $product): ?>
            <div class="swiper-slide text-center">

                <div class="card text-white shadow-lg" style="border: 0 !important; ">
                    <img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'list') ?>" class="card-img">
                    <div class="card-img-overlay">
                        <h3 class="shop-widget-caption"
                            style="color: white; text-shadow: black 2px 2px 1px"><?= $product->getName() ?></h3>
                    </div>
                    <a href="<?= Url::to(['/shop/product/' . $product->id]) ?>" class="stretched-link"></a>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>