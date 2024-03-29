<?php

use booking\entities\Lang;
use booking\entities\shops\products\Product;
use booking\helpers\CurrencyHelper;
use frontend\widgets\design\BtnWish;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $product Product */



$url = Url::to(['/shop/product/' . $product->id]);
?>

<div class="product-layout product-grid col-md-4 col-6 col-lg-3" style="padding-left: 5px; padding-right: 5px;">
    <div class="product-thumb holder" style="border-radius: 5px">
        <?php if ($product->mainPhoto): ?>
            <div class="image">
                <div class="item-responsive item-1-1by1">
                    <div class="content-item">
                <a href="<?=Html::encode($url)?>">
                    <img src="<?=Html::encode($product->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>"
                         alt="<?= $product->mainPhoto->getAlt()?>" class="img-responsive"
                    title="<?= $product->getDescription()?>"/>
                </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="block-wishlist">
            <?= BtnWish::widget(['url' => Url::to(['/cabinet/wishlist/add-product', 'id' => $product->id]) ]) ?>
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
                        <?php if ($product->saleOn()): ?>
                            <a title="В корзину" href="<?= Url::to(['/shop/cart/add', 'id' => $product->id]) ?>"><i class="fas fa-shopping-cart"></i> В корзину</a>
                        <?php else: ?>
                            <a title="Где купить" href="<?= Url::to(['/shop/'. $product->shop_id]) ?>"><i class="fas fa-map-marked-alt"></i> Купить</a>
                        <?php endif; ?>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
