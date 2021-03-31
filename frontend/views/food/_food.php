<?php

use booking\entities\foods\Food;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use booking\helpers\ReviewHelper;
use booking\helpers\SysHelper;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $food Food */
$mobile = SysHelper::isMobile();
?>

<?php $url = Url::to(['/food/view', 'id' => $food->id]) ?>

<div class="card mb-3 p-2" style="border: 0 !important; ">
    <div class="holder"> <!-- style="position: relative" -->
        <?php if ($food->mainPhoto): ?>
            <div itemscope itemtype="https://schema.org/ImageObject">
                <a href="<?= Html::encode($url) ?>">
                    <img data-src="<?= Html::encode($food->mainPhoto->getThumbFileUrl('file', $mobile ? 'catalog_list_mobile' : 'catalog_list_food')) ?>"
                         alt="<?= $food->mainPhoto->getAlt() ?>"
                         title="<?= $food->name ?>"
                         class="card-img-top lazyload" itemprop="contentUrl"/>
                </a>
                <meta itemprop="name"
                      content="<?= empty($food->mainPhoto->alt) ? 'Где поесть в Калининграде' : $food->mainPhoto->getAlt() ?>">
                <meta itemprop="description" content="<?= $food->name ?>">
            </div>
        <?php endif; ?>
        <div class="block-wishlist">
            <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                    title="<?= Lang::t('В избранное') ?>"
                    href="<?= Url::to(['/cabinet/wishlist/add-food', 'id' => $food->id]) ?>"
                    data-method="post">
                <i class="fa fa-heart"></i>
            </button>
        </div>
        <?php if ($food->isNew()): ?>
            <div class="new-object-booking"><span class="new-text">new</span></div>
        <?php endif; ?>
    </div>
    <div class="card-body color-card-body pb-0">
        <div style="font-size: 12px; color: var(--main-nav-color); margin-top: -10px;">
            <i class="fas fa-utensils"></i>
            <?php foreach ($food->kitchens as $i => $kitchen): ?>
                <a href="<?= Url::to(['/foods', 'SearchFoodForm' => ['kitchen_id' => $kitchen->id]]) ?>"><?= Lang::t($kitchen->name) ?></a> <?= ($i < count($food->kitchens) - 1) ? '|': ''?>
            <?php endforeach; ?>
        </div>
        <a href="<?= Html::encode($url) ?>">
            <h2 class="card-title card-object pt-3"><?= Html::encode($food->name) ?></h2>
        </a>

    </div>
    <div class="card-footer color-card-body">
        <?php foreach ($food->categories as $i => $category): ?>
            <a href="<?= Url::to(['/foods', 'SearchFoodForm' => ['category_id' => $category->id]]) ?>"><?= Lang::t($category->name) ?></a> <?= ($i < count($food->categories) - 1) ? '|': ''?>
        <?php endforeach; ?>
    </div>
    <a href="<?= Html::encode($url) ?>">
        <div class="card-footer">
            <div class="d-flex">
                <div class="p-0">
                    <?= RatingWidget::widget(['rating' => $food->rating]) ?>
                </div>
                <div class="ml-auto p-0"> <!-- pull-right rating-->
                    <?= ReviewHelper::text($food->reviews)?>
                </div>
            </div>
        </div>
    </a>

</div>
