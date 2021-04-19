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


$this->title = $this->title = $product->meta->title ? Lang::t($product->meta->title) : $product->getName();;
$this->registerMetaTag(['name' => 'description', 'content' => $product->meta->description]);
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
                    } ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <h1 class="caption-product"><?= Html::encode($product->name) ?></h1> <!-- Заголовок товара-->
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
                        <span class="price-card product"><?= CurrencyHelper::get($product->cost); ?></span>
                    </li>
                    <li> <?= $product->isAd() ? '' : Lang::t('На складе: ') . $product->quantity; ?></li>
                </ul>
                <div id="product" class="required">
                    <?php if (!$product->isAd()): ?>
                        <?= Html::beginForm(['/shop/cart/add', 'id' => $product->id]); ?>
                        <div class="form-group">
                            <?= Html::submitButton('В корзину', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
                        </div>
                        <?= Html::endForm() ?>
                    <?php else: ?>
                        <div class="form-group">
                            <?= Html::a('Где купить', Url::to(['shop/' . $product->shop_id]), ['class' => 'btn btn-primary btn-lg btn-block']) ?>
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
        <?php if ($product->isAd()): ?>
            <div class="py-2"
                 style="font-size: 13px;"><?= Lang::t('Магазин') . ' ' . $product->shop->getName() . Lang::t(' не осуществляет онлайн-продажи через данную плошадку') ?></div>
            <div>Товар можно приобрести по адресу:</div>
            <?php foreach ($product->shop->addresses as $address) {
                echo '<div class="pl-3"><i class="fas fa-map-marker-alt"></i>&#160;' . $address->address . '&#160;&#160;<i class="fas fa-phone-alt"></i>' . $address->phone . '</div>';
            } ?>
            <?php if (count($product->shop->contactAssign) > 0): ?>
                <div class="pt-2"><?= Lang::t('Контакты:') ?></div>
            <?php endif; ?>
            <?php foreach ($product->shop->contactAssign as $contact): ?>
                <div class="pl-3">
                    <img src="<?= $contact->contact->getThumbFileUrl('photo', 'list') ?>"/>&#160;
                    <?php if ($contact->contact->type == Contact::NO_LINK): ?>
                        <?= Html::encode($contact->value) ?>
                    <?php else: ?>
                        <a href="<?= $contact->contact->prefix . $contact->value ?>"
                           target="_blank" rel="nofollow"><?= Html::encode($contact->value) ?></a>
                    <?php endif; ?>
                    &#160;<?= Html::encode($contact->description) ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="pt-3 pb-1" style="font-size: 13px;">
                <?= Lang::t('Магазин') . ' ' . $product->shop->getName() . Lang::t(' осуществляет доставку по России следующими ТК:') ?>
                <?php foreach ($product->shop->delivery->deliveryCompany as $item): ?>
                    <?= $item; ?>
                <?php endforeach; ?>
            </div>
            <div class="pl-3">
                <?= Lang::t('Минимальная сумма заказа для доставки в регионы: ') . CurrencyHelper::stat($product->shop->delivery->minAmountCompany) ?>
            </div>
            <div class="pl-3">
                <?php if ($product->shop->delivery->period == 0): ?>
                    <?= Lang::t('Отправка осуществляется в день заказа ') ?>
                <?php else: ?>
                    <?= Lang::t('Отправка товара производится ') . $product->shop->delivery->period . Lang::t(' раз в неделю') ?>
                <?php endif; ?>
            </div>

            <?php if ($product->shop->delivery->onCity): ?>
                <div class="pt-3 pb-1" style="font-size: 13px;">
                    <?= Lang::t('Имеется доставка по городу Калининград: ') ?>
                </div>
                <div class="pl-3">
                    <?= Lang::t('Минимальная сумма заказа для доставки ') . CurrencyHelper::stat($product->shop->delivery->minAmountCity) ?>
                    <br>
                    <?= Lang::t('Стоимость доставки ') . CurrencyHelper::cost($product->shop->delivery->costCity) ?>
                </div>
            <?php endif; ?>
            <?php if ($product->shop->delivery->onPoint): ?>
                <div class="pt-3 pb-1" style="font-size: 13px;">
                    <?= Lang::t('Имеется возможность самостоятельно забрать заказ в Калининграде') ?>
                </div>
            <?php endif; ?>

            <span class="mt-3 badge badge-success" style="font-size: 12px">Защищенный платеж</span> продавец получит деньги после отправки заказа покупателю

        <?php endif; ?>
    </div>
</div>
<!-- ОТЗЫВЫ -->
<div class="card my-3">
    <div class="card-body">
        <?= ReviewsWidget::widget(['reviews' => $product->reviews]); ?>
    </div>
    <div class="row">
        <div class="col m-2">
            <?= NewReviewProductWidget::widget(['product_id' => $product->id]); ?>
        </div>
    </div>
</div>


<div itemtype="https://schema.org/Product" itemscope>
    <meta itemprop="name" content="<?= $product->getName() ?>">
    <meta itemprop="description" content="<?= $product->getDescription() ?>">
    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        <link itemprop="contentUrl" href="<?= $product->mainPhoto->getUploadedFileUrl('file') ?>"/>
    </div>
    <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
        <meta itemprop="priceCurrency" content="RUB">
        <meta itemprop="price" content="<?= $product->cost ?>">
        <link itemprop="availability" href="https://schema.org/InStock"/>
    </div>
    <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
        <meta itemprop="ratingValue" content="<?= $product->rating ?>">
        <meta itemprop="reviewCount" content="<?= count($product->reviews) + 1 ?>">
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




