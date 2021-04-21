<?php

use booking\entities\admin\Contact;
use booking\entities\Lang;
use booking\entities\shops\Delivery;
use booking\entities\shops\products\Material;
use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
use booking\forms\booking\ReviewForm;
use booking\helpers\CurrencyHelper;

use booking\helpers\funs\WorkModeHelper;
use booking\helpers\ReviewHelper;
use booking\helpers\shops\ManufacturedHelper;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\assets\SwiperAsset;
use frontend\widgets\GalleryWidget;
use frontend\widgets\legal\BookingObjectWidget;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;

use frontend\widgets\reviews\NewReviewProductWidget;
use frontend\widgets\reviews\NewReviewShopWidget;
use frontend\widgets\reviews\ReviewsWidget;
use frontend\widgets\shop\ShopWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $shop Shop */
/* @var $this \yii\web\View */

/* @var $reviewForm ReviewForm */


$this->title = $this->title = $shop->meta->title ? Lang::t($shop->meta->title) : $shop->getName();;
$this->registerMetaTag(['name' => 'description', 'content' => $shop->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $shop->meta->keywords]);
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => '/shops'];

$this->params['breadcrumbs'][] = Lang::t('Магазины');
$this->params['breadcrumbs'][] = $shop->getName();
$this->params['canonical'] = Url::to(['/shop/catalog/shop', 'id' => $shop->id], true);

//$this->params['active_category'] = $product->category;
$mobile = SysHelper::isMobile();

SwiperAsset::register($this);
MagnificPopupAsset::register($this);
?>

<h1><?= Html::encode($shop->getName()) ?></h1>
<!-- ФОТО -->
<div class="card my-3">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="pb-4 thumbnails gallery" style="margin-left: 0 !important;"
                     xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
                    <?php foreach ($shop->photos as $i => $photo) {
                        echo GalleryWidget::widget([
                            'photo' => $photo,
                            'iterator' => $i,
                            'count' => count($shop->photos),
                            'name' => $shop->getName(),
                            'description' => $shop->description,
                        ]);
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ОПИСАНИЕ -->
<div class="card my-3">
    <div class="card-body">
        <p>
            <?= Yii::$app->formatter->asNtext($shop->description) ?>
        </p>
        <?php if ($shop->isAd()): ?>
            <div class="pt-2 pb-1" style="font-size: 16px"><?= Lang::t('Режим работы') ?>:</div>

            <?php foreach ($shop->workModes as $i => $workMode) {
                if ($workMode->day_begin != '')
                    echo '&#160;&#160;' . WorkModeHelper::week($i) . ':&#160;<i class="far fa-clock"></i>&#160;' . $workMode->day_begin . ' - ' . $workMode->day_end . '<br>';
            } ?>
        <?php endif; ?>
    </div>
</div>
<!-- ТОВАРЫ -->
<div class="card my-3">
    <div class="card-body">

        <span style="font-size: 16px"><?= Lang::t('Другие товары продавца ') . '(' . count($shop->activeProducts) . ')' ?></span>
        <?= ShopWidget::widget(['shop' => $shop,]) ?>
    </div>
</div>
<!-- ДОСТАВКА И ОПЛАТА -->
<div class="card my-3">
    <div class="card-body">
        <?= $this->render('_delivery', [
            'shop' => $shop,
        ])?>
    </div>
</div>
<!-- ОТЗЫВЫ -->
<div class="card my-3">
    <div class="card-body">
        <?= ReviewsWidget::widget(['reviews' => $shop->reviews]); ?>
    </div>
    <div class="row">
        <div class="col m-2">
            <?= NewReviewShopWidget::widget(['shop_id' => $shop->id]); ?>
        </div>
    </div>
</div>


Schema.org Магазина

<?php $js = <<<EOD
    $(document).ready(function() {
        $('.thumbnails').magnificPopup({
            type:'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
    });
EOD;
$this->registerJs($js); ?>




