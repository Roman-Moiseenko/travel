<?php

use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use frontend\widgets\design\BtnWish;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $fun Fun */
?>

<?php $url = Url::to(['/fun/view', 'id' => $fun->id]) ?>

<div class="card p-0 my-3">
    <div class="card-body p-0">
        <div class="image-fun-list"> <!-- style="position: relative" -->
            <div class="holder">
            <?php if ($fun->mainPhoto): ?>
                <div itemscope itemtype="https://schema.org/ImageObject">
                    <a href="<?= Html::encode($url) ?>">
                        <img src="<?= Html::encode($fun->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt="<?= $fun->mainPhoto->getAlt() ?>"
                             class="img-responsive" itemprop="contentUrl"/>
                    </a>
                    <meta itemprop="name" content="<?= empty($fun->mainPhoto->getAlt()) ? 'Развлечения и отдых в Калининграде' : $fun->mainPhoto->getAlt() ?>">
                    <meta itemprop="description" content="<?= $fun->getName() ?>">
                </div>
            <?php endif; ?>
            <div class="block-wishlist">
                <?= BtnWish::widget(['url' => Url::to(['/cabinet/wishlist/add-fun', 'id' => $fun->id]) ]) ?>
            </div>
            <?php if ($fun->isNew()): ?>
                <div class="new-object-booking"><span class="new-text">new</span></div>
            <?php endif; ?>
            </div>
        </div>
        <div class="caption-fun-list px-2">
            <div class="d-flex flex-column align-items-stretch" style="height: 228px">
                <div class="pt-3 text-center">
                    <a href="<?= Html::encode($url) ?>">
                    <h2 class="card-title card-object"><?= Html::encode($fun->getName()) ?></h2>
                    </a>
                </div>
                <div class="mb-auto text-justify">
                    <?= (StringHelper::truncateWords(strip_tags($fun->getDescription()), 20)) ?>
                </div>
                <div class="category-card pt-4">

                </div>

                <div style="border: 0 !important; background-color: white !important;">
                    <a href="<?= Url::to(['/funs/category', 'id' => $fun->type_id]) ?>"><?= Lang::t($fun->type->name) ?></a>
                </div>
                <a href="<?= Html::encode($url) ?>">
                <div class="color-card-footer margin-card-footer">
                    <div class="d-flex p-3">
                    <div class="pl-4 py-2">
                        <span class="price-card"><?= CurrencyHelper::get($fun->baseCost->adult) ?></span>
                    </div>
                    <div class="ml-auto">
                        <?= RatingWidget::widget(['rating' => $fun->rating]) ?>
                        <span class="badge badge-success"><?= ($fun->prepay == 0) ? Lang::t('без предоплаты') : ($fun->prepay != 100 ? Lang::t('предоплата') . ' '. $fun->prepay .'%' : '' ) ?></span>
                    </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div itemtype="https://schema.org/TouristTrip" itemscope>
    <meta itemprop="name" content="<?= Lang::t('Мероприятие ') . $fun->getName() ?>" />
    <meta itemprop="description" content="<?= strip_tags($fun->getDescription()) ?>" />
    <meta itemprop="touristType" content="<?= Lang::t($fun->type->name) ?>" />
    <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
        <meta itemprop="name" content="<?= $fun->getName() ?>" />
        <meta itemprop="description" content="<?= Lang::t('Цена за билет') ?>" />
        <meta itemprop="price" content="<?= $fun->baseCost->adult ?>" />
        <meta itemprop="priceCurrency" content="RUB" />
        <link itemprop="url" href="<?= Url::to(['/fun/view', 'id' => $fun->id], true) ?>" />
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
            <meta itemprop="name" content="<?= $fun->legal->caption ?>" />
            <link itemprop="url" href="<?= Url::to(['legals/view', 'id' => $fun->legal->id], true) ?>" />
            <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
            <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
            </div>
        </div>
    </div>
</div>
