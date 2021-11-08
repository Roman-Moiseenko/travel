<?php

use booking\entities\touristic\fun\Fun;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use frontend\widgets\design\BtnWish;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $fun Fun */
?>

<?php $url = Url::to(['/funs/funs/fun', 'id' => $fun->id]) ?>

<div class="card mb-3 p-2" style="border: 0 !important; ">
    <div class="holder"> <!-- style="position: relative" -->
        <?php if ($fun->mainPhoto): ?>
            <div itemscope itemtype="https://schema.org/ImageObject">
                    <img src="<?= Html::encode($fun->mainPhoto->getThumbFileUrl('file', 'catalog_list_mobile')) ?>" alt="<?= $fun->mainPhoto->getAlt() ?>"
                         class="card-img-top" itemprop="contentUrl"/>
                <meta itemprop="name" content="<?= empty($fun->mainPhoto->getAlt()) ? 'Развлечения и отдых в Калининграде' : $fun->mainPhoto->getAlt() ?>">
                <meta itemprop="description" content="<?= $fun->getName() ?>">
            </div>
        <?php endif; ?>
        <div class="block-wishlist">
            <?= '' //BtnWish::widget(['url' => Url::to(['/cabinet/wishlist/add-fun', 'id' => $fun->id]) ]) ?>
        </div>
        <?php if ($fun->isFeatured()): ?>
            <div class="new-object-booking"><span class="new-text">+</span></div>
        <?php endif; ?>
    </div>
    <div class="card-body color-card-body">
        <h2 class="card-title card-object"><?= Html::encode($fun->getName()) ?></h2>
        <p class="card-text" style="height: available">
        <div class="mb-auto text-justify" style="font-size: 16px; line-height: 22px">
            <?= $fun->getDescription() ?>
        </div>
        </p>
    </div>
    <div class="card-footer color-card-body">
    </div>
    <div class="mt-auto card-footer color-card-footer">
        <div class="d-flex p-1">
        <div class="p-2">
            <span class="price-card"><?= $fun->contact->getFirstContact() ?></span>
        </div>
        <div class="ml-auto">
        </div>
        </div>
    </div>
    <a href="<?= Html::encode($url) ?>" class="stretched-link"></a>
</div>


<div itemtype="https://schema.org/TouristTrip" itemscope>
    <meta itemprop="name" content="<?= 'Мероприятие ' . $fun->getName() ?>" />
    <meta itemprop="description" content="<?= strip_tags($fun->getDescription()) ?>" />
    <meta itemprop="touristType" content="<?= $fun->category->name ?>" />
    <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
        <meta itemprop="name" content="<?= $fun->getName() ?>" />
        <meta itemprop="description" content="<?= 'Цена за билет' ?>" />
        <meta itemprop="price" content="0" />
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
            <meta itemprop="name" content="Кёнигс.РУ" />
            <link itemprop="url" href="http://koenigs.ru" />
            <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
            <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
            </div>
        </div>
    </div>
</div>
