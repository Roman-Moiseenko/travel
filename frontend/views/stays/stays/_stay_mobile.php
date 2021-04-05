<?php

use booking\entities\booking\stays\Stay;
use booking\entities\booking\stays\Type;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use booking\helpers\stays\StayHelper;
use booking\helpers\SysHelper;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $stay Stay */

//SysHelper::_renderDate()
$arr = [
    'date_from' => $this->params['search']['date_from'],
    'date_to' => $this->params['search']['date_to'],
    'guest' => $this->params['search']['guest'],
    'children' => $this->params['search']['children'],
    'children_age' => $this->params['search']['children_age'],
];
$arr_city = $arr;
$arr_city['city'] = $stay->city;

$url = Url::to(['/stay/view', 'id' => $stay->id, 'SearchStayForm' => $arr]);
$url_map = Url::to(['/stay/view', 'id' => $stay->id, 'SearchStayForm' => $arr, 'map' => true]);
$url_city = Url::to(['/stays', 'SearchStayForm' => $arr_city]);

$arr_category = array_map(function (Type $category) use ($stay) {
    return $stay->type_id == $category->id ? ['checked' => 1] : ['checked' => 0];
}, Type::find()->orderBy('sort')->all());

$url_category = Url::to(['/stays', 'SearchStayForm' => $arr, 'categories' => $arr_category]);
?>

<div class="card mb-3 p-2" style="border: 0 !important; ">
    <div class="holder"> <!-- style="position: relative" -->
        <?php if ($stay->mainPhoto): ?>
            <div itemscope itemtype="https://schema.org/ImageObject">
                <a href="<?= Html::encode($url) ?>">
                    <img src="<?= Html::encode($stay->mainPhoto->getThumbFileUrl('file', 'catalog_list_mobile')) ?>"
                         alt="<?= $stay->mainPhoto->getAlt() ?>"
                         class="card-img-top" itemprop="contentUrl"/>
                </a>
                <meta itemprop="name"
                      content="<?= empty($stay->mainPhoto->alt) ? 'Аренда жилья в Калининграде' : $stay->mainPhoto->getAlt() ?>">
                <meta itemprop="description" content="<?= $stay->getName() ?>">
            </div>
        <?php endif; ?>
        <div class="block-wishlist">
            <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                    title="<?= Lang::t('В избранное') ?>"
                    href="<?= Url::to(['/cabinet/wishlist/add-stay', 'id' => $stay->id]) ?>"
                    data-method="post">
                <i class="fa fa-heart"></i>
            </button>
        </div>
        <?php if ($stay->isNew()): ?>
            <div class="new-object-booking"><span class="new-text">new</span></div>
        <?php endif; ?>
    </div>
    <div class="card-body color-card-body">
        <a href="<?= Html::encode($url) ?>">
            <h2 class="card-title card-object"><?= Html::encode($stay->getName()) ?></h2>
        </a>
        <div class="card-text" style="height: available">
            <!-- БЛОК ОПИСАНИЯ -->
            <div>
                <a href="<?= $url_map ?>" class="">
                    <?= $stay->address->address ?>
                </a>
            </div>
            <div>
                <i class="fas fa-map-marker-alt"></i> <?= ($stay->to_center < 1000) ? $stay->to_center . ' м' : round($stay->to_center / 1000, 1) . ' км' ?>
                до центра
            </div>
            <div>
                <i class="fas fa-user"></i> х <?= $stay->params->guest ?>&#8195;&#8195;
                <i class="fas fa-person-booth"></i> х <?= StayHelper::textRooms($stay) ?>&#8195;&#8195;
                <i class="fas fa-bed"></i> х <?= StayHelper::textBeds($stay) ?>
            </div>
            <div class="pb-1">
                <?php if ($stay->rules->parking->is()): ?>
                    <i class="fas fa-parking"></i>
                    <?php if ($stay->rules->parking->free()): ?>
                        <span class="badge badge-success">free</span>
                    <?php else: ?>
                        <span class="badge badge-danger">pay</span>
                    <?php endif; ?>
                    &#8195;
                <?php endif; ?>
                <?php if ($stay->rules->wifi->is()): ?>
                    <i class="fas fa-wifi"></i>
                    <?php if ($stay->rules->wifi->free()): ?>
                        <span class="badge badge-success">free</span>
                    <?php else: ?>
                        <span class="badge badge-danger">pay</span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?= (StringHelper::truncateWords(strip_tags($stay->getDescription()), 10)) ?>
            <div class="category-card">
                <a href="<?= $url_city ?>"><?= Lang::t($stay->city) ?></a>
                &#8226;
                <span style="border: 0 !important;">
                        <a href="<?= $url_category ?>"><?= Lang::t($stay->type->name) ?></a>
                    </span>
            </div>
        </div>
    </div>
    <div class="mt-auto card-footer color-card-footer">
        <div class="d-flex">
            <div>
                <div class="pl-4 py-2">
                    <span class="price-card"><?= CurrencyHelper::get($stay->costBySearchParams($arr)) ?></span>
                </div>
                <div class="pull-right rating pl-4 pb-2">
                    <?= RatingWidget::widget(['rating' => $stay->rating]) ?>
                </div>
            </div>
            <div class="ml-auto mt-1 mr-1">
                <a href="<?= Html::encode($url) ?>" class="btn btn-lg btn-primary"
                   style="height: 58px; align-items: center; display: inline-flex;">Проверить ></a>
            </div>
        </div>
    </div>

</div>
<div itemtype="https://schema.org/Offer" itemscope>
    <meta itemprop="name" content="<?= $stay->getName() ?>" />
    <meta itemprop="description" content="<?= Lang::t('Бронирование жилья') ?>" />
    <meta itemprop="price" content="<?= $stay->cost_base ?>" />
    <meta itemprop="priceCurrency" content="RUB" />
    <link itemprop="url" href="<?= Url::to(['/stay/view', 'id' => $stay->id], true) ?>" />
    <div itemprop="eligibleRegion" itemtype="https://schema.org/Country" itemscope>
        <meta itemprop="name" content="Russia, Kaliningrad" />
        <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">,
        <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
            <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
            <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
            <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
        </div>
    </div>
    <div itemprop="offeredBy" itemtype="https://schema.org/Organization" itemscope>
        <meta itemprop="name" content="<?= $stay->legal->caption ?>" />
        <link itemprop="url" href="<?= Url::to(['legals/view', 'id' => $stay->legal->id], true) ?>" />
        <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">,
        <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
            <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
            <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
            <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
        </div>
    </div>
</div>