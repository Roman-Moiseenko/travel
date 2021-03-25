<?php

use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $tour Tour */
$mobile = SysHelper::isMobile();
?>

<?php $url = Url::to(['/tour/view', 'id' => $tour->id]) ?>

<div class="card mb-3 p-2" style="border: 0 !important; ">
    <div class="holder"> <!-- style="position: relative" -->
        <?php if ($tour->mainPhoto): ?>
            <div itemscope itemtype="https://schema.org/ImageObject">
                <a href="<?= Html::encode($url) ?>">
                    <img data-src="<?= Html::encode($tour->mainPhoto->getThumbFileUrl('file', $mobile ? 'catalog_list_mobile' : 'catalog_list')) ?>"
                         alt="<?= $tour->mainPhoto->getAlt() ?>"
                         title="<?= $tour->getName() ?>"
                         class="card-img-top lazyload" itemprop="contentUrl"/>
                </a>
                <meta itemprop="name"
                      content="<?= empty($tour->mainPhoto->alt) ? 'Туры и экскурсии в Калининграде' : $tour->mainPhoto->getAlt() ?>">
                <meta itemprop="description" content="<?= $tour->getName() ?>">
            </div>
        <?php endif; ?>
        <div class="block-wishlist">
            <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                    title="<?= Lang::t('В избранное') ?>"
                    href="<?= Url::to(['/cabinet/wishlist/add-tour', 'id' => $tour->id]) ?>"
                    data-method="post">
                <i class="fa fa-heart"></i>
            </button>
        </div>
        <?php if ($tour->isNew()): ?>
            <div class="new-object-booking"><span class="new-text">new</span></div>
        <?php endif; ?>
    </div>

    <div class="card-body color-card-body">
        <div style="font-size: 12px; color: var(--main-nav-color); margin-top: -15px;">
            <?= $tour->params->private ? Lang::t('Индивидуальная') : Lang::t('Групповая') ?>
            <i class="fas fa-user-friends"></i> <?= $tour->params->groupMax ?>
            <i class="fas fa-clock"></i> <?= Lang::duration($tour->params->duration) ?>
        </div>
        <a href="<?= Html::encode($url) ?>">
            <h2 class="card-title card-object"><?= Html::encode($tour->getName()) ?></h2>
        </a>
        <p class="card-text" style="height: available">
            <div class="mb-auto text-justify">
                <?= (StringHelper::truncateWords(strip_tags($tour->getDescription()), 20)) ?>
            </div>
            <div class="category-card pt-4">

            </div>
        </p>
    </div>
    <div class="card-footer color-card-body">
        <?php foreach ($tour->types as $type): ?>
            <a href="<?= Url::to(['/tours/category', 'id' => $type->id]) ?>"><?= Lang::t($type->name) ?></a>&#160;|&#160;
        <?php endforeach; ?>
        <a href="<?= Url::to(['/tours/category', 'id' => $tour->type->id]) ?>"><?= Lang::t($tour->type->name) ?></a>
    </div>
    <a href="<?= Html::encode($url) ?>">
        <div class="mt-auto card-footer color-card-footer">
            <div class="d-flex">
                <div class="p-2">
                    <div class="price-card"><?= CurrencyHelper::get($tour->baseCost->adult) ?></div>
                    <span style="color: #3c3c3c; font-size: 12px"><?= $tour->params->private ? Lang::t('за экскурсию') : Lang::t('за человека') ?></span>
                </div>
                <div class="ml-auto"> <!-- pull-right rating-->
                    <?= RatingWidget::widget(['rating' => $tour->rating]) ?>
                    <span class="badge badge-success"><?= ($tour->prepay == 0) ? Lang::t('без предоплаты') : ($tour->prepay != 100 ? Lang::t('предоплата') . ' '. $tour->prepay .'%' : '' ) ?></span>
                </div>
            </div>
        </div>
    </a>
</div>
