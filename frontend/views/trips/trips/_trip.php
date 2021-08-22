<?php

use booking\entities\booking\trips\Trip;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use booking\helpers\trips\TripHelper;
use frontend\widgets\design\BtnWish;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $trip Trip */
$mobile = SysHelper::isMobile();
?>

<?php $url = Url::to(['/trip/view', 'id' => $trip->id]) ?>

<div class="card mb-3 p-2" style="border: 0 !important; border-radius: 20px !important;">
    <div class="holder"> <!-- style="position: relative" -->
        <?php if ($trip->mainPhoto): ?>
            <div itemscope itemtype="https://schema.org/ImageObject">
                <div class="item-responsive <?= $mobile ? 'item-2-0by1' : 'item-3-0by1'?>">
                    <div class="content-item">
                <a href="<?= Html::encode($url) ?>">
                    <img loading="lazy" src="<?= Html::encode($trip->mainPhoto->getThumbFileUrl('file', $mobile ? 'catalog_list_mobile' : 'catalog_list_3x')) ?>"
                         alt="<?= $trip->mainPhoto->getAlt() ?>"
                         title="<?= $trip->getName() ?>"
                         class="card-img-top"
                         style="border-top-left-radius: 20px; border-top-right-radius: 20px;"
                    />
                    <link  itemprop="contentUrl" href="<?= Html::encode($trip->mainPhoto->getThumbFileUrl('file', $mobile ? 'catalog_list_mobile' : 'catalog_list')) ?>">
                </a>
                    </div>
                </div>
                <meta itemprop="name"
                      content="<?= empty($trip->mainPhoto->alt) ? 'Туры и экскурсии в Калининграде' : $trip->mainPhoto->getAlt() ?>">
                <meta itemprop="description" content="<?= $trip->getName() ?>">
            </div>
        <?php endif; ?>
        <div class="block-wishlist">
            <?= BtnWish::widget(['url' => Url::to(['/cabinet/wishlist/add-trip', 'id' => $trip->id]) ]) ?>
        </div>
        <?php if ($trip->isNew()): ?>
            <div class="new-object-booking"><span class="new-text">new</span></div>
        <?php endif; ?>
    </div>
    <div class="card-body color-card-body pb-0">
        <a href="<?= Html::encode($url) ?>">
            <h2 class="card-title card-object" style="text-transform: uppercase;"><?= Html::encode($trip->getName()) ?></h2>
        </a>
            <div class="card-text mb-auto text-justify"  style="height: available">
                <?= '' ;//(StringHelper::truncateWords(strip_tags($trip->getDescription()), 20)) ?>
            </div>

    </div>
    <div class="card-footer color-card-body pt-1">
        <div style="font-size: 12px; color: var(--main-nav-color)">
            <i class="fas fa-hourglass-half"></i> <?= TripHelper::duration($trip->params->duration) ?>
        </div>
        <span style="font-size: 12px; color: var(--main-nav-color)">
            <i class="fas fa-suitcase"></i>
        </span>
        <?php foreach ($trip->types as $type): ?>
            <a href="<?= Url::to(['/trips/category', 'id' => $type->id]) ?>"><?= Lang::t($type->name) ?></a>&#160;|&#160;
        <?php endforeach; ?>
        <a href="<?= Url::to(['/trips/category', 'id' => $trip->type->id]) ?>"><?= Lang::t($trip->type->name) ?></a>
    </div>
    <a href="<?= Html::encode($url) ?>">
        <div class="mt-auto card-footer color-card-footer"  style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
            <div class="d-flex">
                <div class="p-2">
                    <div class="price-card"><?= CurrencyHelper::get($trip->minAmount()) ?></div>

                </div>
                <div class="ml-auto"> <!-- pull-right rating-->
                    <?= RatingWidget::widget(['rating' => $trip->rating]) ?>
                    <span class="badge badge-success"><?= ($trip->prepay == 0) ? Lang::t('без предоплаты') : ($trip->prepay != 100 ? Lang::t('предоплата') . ' '. $trip->prepay .'%' : '' ) ?></span>
                </div>
            </div>
        </div>
    </a>
    <div itemtype="https://schema.org/TouristTrip" itemscope>
        <meta itemprop="name" content="<?= Lang::t('Тур ') . $trip->getName() ?>" />
        <meta itemprop="description" content="<?= strip_tags($trip->getDescription()) ?>" />
        <?php foreach ($trip->types as $type): ?>
            <meta itemprop="touristType" content="<?= Lang::t($type->name) ?>" />
        <?php endforeach; ?>
        <meta itemprop="touristType" content="<?= Lang::t($trip->type->name) ?>" />
        <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
            <meta itemprop="name" content="<?= $trip->getName() ?>" />
            <meta itemprop="description" content="<?= Lang::t('Цена за тур') ?>" />
            <meta itemprop="price" content="<?= $trip->minAmount() ?>" />
            <meta itemprop="priceCurrency" content="RUB" />
            <link itemprop="url" href="<?= Url::to(['/trip/view', 'id' => $trip->id], true) ?>" />
            <div itemprop="eligibleRegion" itemtype="https://schema.org/Country" itemscope>
                <meta itemprop="name" content="Russia, Kaliningrad" />
                <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
                <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                    <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                    <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                    <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
                </div>
            </div>
            <div itemprop="offeredBy" itemtype="https://schema.org/Organization" itemscope>
                <meta itemprop="name" content="<?= $trip->legal->caption ?>" />
                <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
                <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                    <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                    <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                    <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
                </div>
                <link itemprop="url" href="<?= Url::to(['legals/view', 'id' => $trip->legal->id], true) ?>" />
            </div>
        </div>
    </div>
</div>
