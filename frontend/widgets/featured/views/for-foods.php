<?php

use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use frontend\widgets\design\BtnWish;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $tour Tour */

$mobile = SysHelper::isMobile();
$url = Url::to(['/tour/view', 'id' => $tour->id])
?>
<div class="card">
    <div class="holder"> <!-- style="position: relative" -->
        <?php if ($tour->mainPhoto): ?>
            <div itemscope itemtype="https://schema.org/ImageObject">
                <div class="item-responsive item-2-0by1">
                    <div class="content-item">
                        <a href="<?= Html::encode($url) ?>">
                            <img loading="lazy" src="<?= Html::encode($tour->mainPhoto->getThumbFileUrl('file', 'catalog_list_mobile')) ?>"
                                 alt="<?= $tour->mainPhoto->getAlt() ?>"
                                 title="<?= $tour->getName() ?>"
                                 class="card-img-top"/>
                            <link  itemprop="contentUrl" href="<?= Html::encode($tour->mainPhoto->getThumbFileUrl('file', 'catalog_list_mobile')) ?>">
                        </a>
                    </div>
                </div>
                <meta itemprop="name"
                      content="<?= empty($tour->mainPhoto->alt) ? 'Туры и экскурсии в Калининграде' : $tour->mainPhoto->getAlt() ?>">
                <meta itemprop="description" content="<?= $tour->getName() ?>">
            </div>
        <?php endif; ?>
        <div class="block-wishlist">
            <?= BtnWish::widget(['url' => Url::to(['/cabinet/wishlist/add-tour', 'id' => $tour->id]) ]) ?>
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
            <?= ''; //(StringHelper::truncateWords(strip_tags($tour->getDescription()), 20)) ?>
        </div>
        </p>
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
<div style="text-align: center; padding-top: 8px">
<a href="<?= Url::to(['/tours'])?>"><h3 style="font-size: 14px;"><?= Lang::t('Экскурсии в Калининграде')?></h3></a>
</div>