<?php


use booking\entities\booking\cars\Car;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use frontend\widgets\RatingWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $car Car */
?>

<?php $url = Url::to(['/car/view', 'id' => $car->id]) ?>

<div class="card mb-3 p-2" style="border: 0 !important; ">
    <div class="holder"> <!-- style="position: relative" -->
        <?php if ($car->mainPhoto): ?>
            <div itemscope itemtype="https://schema.org/ImageObject">
                <a href="<?= Html::encode($url) ?>">
                    <img src="<?= Html::encode($car->mainPhoto->getThumbFileUrl('file', 'catalog_list_mobile')) ?>"
                         alt="<?= $car->mainPhoto->getAlt() ?>"
                         class="card-img-top" itemprop="contentUrl"/>
                </a>
                <meta itemprop="name"
                      content="<?= empty($car->mainPhoto->getAlt()) ? 'Прокат авто в Калининграде' : $car->mainPhoto->getAlt() ?>">
                <meta itemprop="description" content="<?= $car->getName() ?>">
            </div>
        <?php endif; ?>
        <div class="block-wishlist">
            <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                    title="<?= Lang::t('В избранное') ?>"
                    href="<?= Url::to(['/cabinet/wishlist/add-car', 'id' => $car->id]) ?>"
                    data-method="post">
                <i class="fa fa-heart"></i>
            </button>
        </div>
        <?php if ($car->isNew()): ?>
            <div class="new-object-booking"><span class="new-text">new</span></div>
        <?php endif; ?>
    </div>
    <div class="card-body color-card-body">
        <a href="<?= Html::encode($url) ?>">
            <h2 class="card-title card-object"><?= Html::encode($car->getName()) ?></h2>
        </a>
        <p class="card-text" style="height: available">
            <div class="mb-auto text-justify">
                <?= (StringHelper::truncateWords(strip_tags($car->getDescription()), 20)) ?>
            </div>

            <div class="category-card pt-4">
                <?= implode(', ', ArrayHelper::map($car->cities, 'id', 'name')) ?>
            </div>
        </p>
    </div>
    <div class="card-footer color-card-body">
        <a href="<?= Url::to(['/cars/category', 'id' => $car->type->id]) ?>"><?= Lang::t($car->type->name) ?></a>
    </div>
    <a href="<?= Html::encode($url) ?>">
        <div class="mt-auto card-footer color-card-footer">
            <div class="d-flex p-1">
                <div class="p-2">
                    <div class="price-card"><?= CurrencyHelper::get($car->cost) ?></div>
                    <span style="color: #3c3c3c; font-size: 12px"><?= Lang::t('за сутки') ?></span>
                </div>
                <div class="ml-auto">
                    <?= RatingWidget::widget(['rating' => $car->rating]) ?>
                </div>
            </div>
        </div>
    </a>
</div>
<div itemtype="https://schema.org/Offer" itemscope>
    <meta itemprop="name" content="<?= $car->getName() ?>" />
    <meta itemprop="description" content="<?= Lang::t('Прокат авто') ?>" />
    <meta itemprop="price" content="<?= $car->cost ?>" />
    <meta itemprop="priceCurrency" content="RUB" />
    <link itemprop="url" href="<?= Url::to(['/car/view', 'id' => $car->id], true) ?>" />
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
        <meta itemprop="name" content="<?= $car->legal->caption ?>" />
        <link itemprop="url" href="<?= Url::to(['legals/view', 'id' => $car->legal->id], true) ?>" />
        <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">,
        <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
            <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
            <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
            <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
        </div>
    </div>
</div>