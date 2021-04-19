<?php

use booking\entities\Lang;
use booking\entities\shops\products\BaseProduct;

/* @var $product BaseProduct */



use booking\helpers\CurrencyHelper;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
$url = Url::to(['/shop/product/' . $product->id]);
?>

<div class="product-layout product-grid col-md-4 col-6 col-lg-3" style="padding-left: 5px; padding-right: 5px;">
    <div class="product-thumb holder" style="border-radius: 5px">
        <?php if ($product->mainPhoto): ?>
            <div class="image">
                <a href="<?=Html::encode($url)?>">
                    <img src="<?=Html::encode($product->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>"
                         alt="<?= $product->mainPhoto->getAlt()?>" class="img-responsive"
                    title="<?= $product->getDescription()?>"/>
                </a>
            </div>
        <?php endif; ?>
        <div class="block-wishlist">
            <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                    title="<?= Lang::t('В избранное') ?>"
                    href="<?= Url::to(['/cabinet/wishlist/add-product', 'id' => $product->id]) ?>"
                    data-method="post">
                <i class="fa fa-heart"></i>
            </button>
        </div>
        <div>
            <div class="caption">
                <a href="<?= Html::encode($url) ?>">
                <h3 class="caption-product-list">
                    <?= Html::encode($product->name) ?>
                </h3>
                </a>
                <a href="<?= Url::to(['/shop/'. $product->shop_id]) ?>">
                <span class="caption-product-shop"><i class="fas fa-store"></i> <?= Html::encode($product->shop->name)?></span>
                </a>
                <?= RatingWidget::widget(['rating' => $product->rating]) ?>
            </div>
            <div class="card-footer">

                <div class="d-flex">
                    <div class="p-1">
                        <div class="price-card shop"><?= CurrencyHelper::get($product->cost) ?></div>
                    </div>
                    <div class="ml-auto"> <!-- pull-right rating-->
                        <?php if (!$product->isAd()): ?>
                            <a title="В корзину" href="<?= Url::to(['/shop/cart/add', 'id' => $product->id]) ?>"><i class="fas fa-shopping-cart"></i> В корзину</a>
                        <?php else: ?>
                            <a title="Где купить" href="<?= Url::to(['/shop/', 'id' => $product->id]) ?>"><i class="fas fa-map-marked-alt"></i> Где купить</a>
                        <?php endif; ?>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
