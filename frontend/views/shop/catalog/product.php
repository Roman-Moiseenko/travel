<?php

use booking\entities\admin\Contact;
use booking\entities\Lang;
use booking\entities\shops\Delivery;
use booking\entities\shops\products\Material;
use booking\entities\shops\products\Product;
use booking\forms\booking\ReviewForm;
use booking\helpers\CurrencyHelper;

use booking\helpers\ReviewHelper;
use booking\helpers\shops\ManufacturedHelper;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\assets\SwiperAsset;
use frontend\widgets\design\BtnAddCart;
use frontend\widgets\design\BtnShop;
use frontend\widgets\design\BtnWish;
use frontend\widgets\GalleryWidget;
use frontend\widgets\legal\BookingObjectWidget;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;

use frontend\widgets\reviews\NewReviewProductWidget;
use frontend\widgets\reviews\ReviewsWidget;
use frontend\widgets\shop\ShopWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $product Product */
/* @var $this \yii\web\View */

/* @var $reviewForm ReviewForm */


$this->title = ($product->meta->title == null) ? $product->getName() . ' - ' . Lang::t('купить в Калининграде') : Lang::t($product->meta->title);

$description = $product->meta->description;

if (empty($description)) {
    $description = $this->title . ' ' . Lang::t('низкая цена, адрес магазина, доставка по России') . ' ' . $product->category->name;
}

$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $product->meta->keywords]);
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => '/shops'];
foreach ($product->category->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => Url::to(['category', 'id' => $parent->id])];
    }
}
$this->params['breadcrumbs'][] = ['label' => $product->category->name, 'url' => Url::to(['category', 'id' => $product->category->id])];
$this->params['breadcrumbs'][] = $product->name;

$this->params['active_category'] = $product->category;
$this->params['canonical'] = Url::to(['/shop/catalog/product', 'id' => $product->id], true);

$mobile = SysHelper::isMobile();

SwiperAsset::register($this);
MagnificPopupAsset::register($this);
?>

<!-- ФОТО И КОРЗИНА -->
<div class="card my-3">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="pb-4 thumbnails gallery" style="margin-left: 0 !important;"
                     xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
                    <?php foreach ($product->photos as $i => $photo) {
                        echo GalleryWidget::widget([
                            'photo' => $photo,
                            'iterator' => $i,
                            'count' => count($product->photos),
                            'name' => $product->getName(),
                            'description' => $product->description,
                        ]);

                        //TODO Заглушка, пока не придумаю решение по лучше
                        if (count($product->photos) == 1) { //доб.2 и 3 фото
                            echo GalleryWidget::widget([
                                'photo' => $photo,
                                'iterator' => 1,
                                'count' => 3,
                                'name' => $product->getName(),
                                'description' => $product->description,
                            ]);
                            echo GalleryWidget::widget([
                                'photo' => $photo,
                                'iterator' => 2,
                                'count' => 3,
                                'name' => $product->getName(),
                                'description' => $product->description,
                            ]);
                        }
                        if (count($product->photos) == 2 && $i = 1) { //доб. 3 фото
                            echo GalleryWidget::widget([
                                'photo' => $photo,
                                'iterator' => 2,
                                'count' => 3,
                                'name' => $product->getName(),
                                'description' => $product->description,
                            ]);
                        }

                    } ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center">
                    <div class="mr-2">
                        <?= BtnWish::widget(['url' => Url::to(['/cabinet/wishlist/add-product', 'id' => $product->id])]) ?>
                    </div>
                    <div class="mr-auto">
                        <h1 class="caption-product"><?= Html::encode($product->name) ?></h1> <!-- Заголовок товара-->
                    </div>
                </div>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?= Url::to(['/shop/' . $product->shop_id]) ?>">
                        <span class="caption-product-shop"><i
                                    class="fas fa-store"></i> <?= Html::encode($product->shop->name) ?></span>
                        </a>
                    </li>
                    <li><?= !empty($product->article) ? 'Артикул: ' . $product->article : '' ?></li>
                    <li>Материал:
                        <?= implode(', ', array_map(function (Material $material) {
                            return $material->name;
                        }, $product->materials)) ?>
                    </li>
                    <li></li>
                </ul>
                <ul class="list-unstyled">
                    <li>
                        <span class="price-card product"><?= CurrencyHelper::get($product->cost, false); ?></span>
                    </li>
                    <li> <?= $product->isAd() ? '' : Lang::t('На складе: ') . $product->quantity; ?></li>
                </ul>
                <div id="product" class="required">
                    <?php if ($product->saleOn()): ?>
                        <?= Html::beginForm(['/shop/cart/add', 'id' => $product->id]); ?>
                        <?= BtnAddCart::widget() ?>
                        <?= Html::endForm() ?>
                    <?php else: ?>
                        <div class="form-group">
                            <?= BtnShop::widget(['url' => Url::to(['shop/' . $product->shop_id])]) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="rating">
                    <p>
                        <?= RatingWidget::widget(['rating' => $product->rating]); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ОПИСАНИЕ -->
<div class="card my-3">
    <div class="card-body">
        <p>
            <?= Yii::$app->formatter->asNtext($product->description) ?>
        </p>
        ХАРАКТЕРИСТИКИ
        <table class="table w-50">
            <?php if (!empty($product->collection)): ?>
                <tr>
                    <td class="characteristic key"><?= Lang::t('Коллекция: ') ?></td>
                    <td class="characteristic value"><?= $product->collection ?></td>
                </tr>
            <?php endif; ?>
            <?php if (!empty($product->color)): ?>
                <tr>
                    <td class="characteristic key"><?= Lang::t('Цвет: ') ?></td>
                    <td class="characteristic value"><?= $product->color ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td class="characteristic key"><?= Lang::t('Производство: ') ?></td>
                <td class="characteristic value"><?= ManufacturedHelper::list()[$product->manufactured_id] ?></td>
            </tr>
            <tr>
                <td class="characteristic key"><?= Lang::t('Размеры (ШхВхГ см): ') ?></td>
                <td class="characteristic value"><?= $product->size->width . 'x' . $product->size->height . 'x' . $product->size->depth ?></td>
            </tr>
            <tr>
                <td class="characteristic key"><?= Lang::t('Масса (г): ') ?></td>
                <td class="characteristic value"><?= $product->weight ?></td>
            </tr>
        </table>
    </div>
</div>
<!-- ТОВАРЫ -->
<div class="card my-3">
    <div class="card-body">

        <span style="font-size: 16px"><?= Lang::t('Другие товары продавца ') . '(' . count($product->shop->activeProducts) . ')' ?></span>
        <?= ShopWidget::widget(['shop' => $product->shop,]) ?>
    </div>
</div>
<!-- ДОСТАВКА И ОПЛАТА -->
<div class="card my-3">
    <div class="card-body">
        <?= $this->render('_delivery', [
            'shop' => $product->shop,
            'sale_on' => $product->saleOn(),
        ]) ?>
    </div>
</div>
<!-- ОТЗЫВЫ -->
<div class="card my-3">
    <div class="card-body">
        <?= ReviewsWidget::widget(['reviews' => $product->reviews]); ?>
        <?= NewReviewProductWidget::widget(['product_id' => $product->id]); ?>
    </div>
</div>


<div itemtype="https://schema.org/Product" itemscope>
    <meta itemprop="name" content="<?= $product->getName() ?>">
    <meta itemprop="description" content="<?= $product->getDescription() ?>">
    <meta itemprop="sku" content="<?= $product->id ?>">
    <meta itemprop="brand" content="<?=$product->getBrand() ?>">
    <link itemprop="url" href="<?= Url::to(['product/view', 'id' => $product->id], true)?>">
    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        <link itemprop="contentUrl" href="<?= $product->mainPhoto->getUploadedFileUrl('file') ?>"/>
    </div>
    <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
        <meta itemprop="priceCurrency" content="RUB">
        <meta itemprop="price" content="<?= $product->cost ?>">
        <link itemprop="availability" href="https://schema.org/InStock"/>
        <meta itemprop="priceValidUntil" content="<?= ((int)(date('Y', time())) + 1) . '-01-01'?>">
    </div>
    <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
        <meta itemprop="ratingValue" content="<?= $product->rating ?? 5 ?>">
        <meta itemprop="reviewCount" content="<?= count($product->reviews) + 1 ?>">
        <meta itemprop="bestRating" content="5">
        <meta itemprop="worstRating" content="0">
    </div>

    <?php foreach ($product->reviews as $review): ?>
        <div itemprop="review" itemscope itemtype="https://schema.org/Review">
            <meta itemprop="author" content="<?= $review->user->personal->fullname->getFullname() ?>">
            <meta itemprop="datePublished" content="<?= date('Y-m-d', $review->created_at) ?>">
            <div itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
                <meta itemprop="worstRating" content="1">
                <meta itemprop="ratingValue" content="<?= $review->vote ?>">
                <meta itemprop="bestRating" content="5">
            </div>
            <meta itemprop="reviewBody" content="<?= $review->text ?>">
        </div>
    <?php endforeach; ?>
</div>

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




