<?php

use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $tour Tour */
?>

<?php $url = Url::to(['/tours/view', 'id' => $tour->id]) ?>

<div class="card m-2">
    <div style="position: relative">
    <?php if ($tour->mainPhoto): ?>
        <a href="<?= Html::encode($url) ?>">
            <img src="<?= Html::encode($tour->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt=""
                 class="card-img-top"/>
        </a>
    <?php endif; ?>
        <button type="button" data-toggle="tooltip" class="btn btn-default"
                title="<?= Lang::t('В избранное') ?>"
                href="<?= Url::to(['/cabinet/wishlist/add-tour', 'id' => $tour->id]) ?>"
                data-method="post" style="width: 40px; position: absolute;top: 0%;left: calc(100% - 40px);">
            <i class="fa fa-heart"></i>
        </button>
    </div>
    <div class="card-body">
        <h4 class="card-title">
            <a href="<?= Html::encode($url) ?>"><?= Html::encode($tour->name) ?></a>

        </h4>
        <p class="card-text" style="height: available">
            <div class="mb-auto">
                <?= Html::encode(StringHelper::truncateWords(strip_tags($tour->description), 10)) ?>
            </div>

        <div class="category-card pt-4">
            <?php foreach ($tour->types as $type): ?>
                <a href=""><?= Lang::t($type->name)  ?></a>&#160;|&#160;
            <?php endforeach; ?>
            <?= Lang::t($tour->type->name) ?>
        </div>
        </p>
    </div>
    <div class="mt-auto card-footer" style="background-color: white;">

        <div class="p-2">
            <span class="price-card"><?= CurrencyHelper::get($tour->baseCost->adult) ?></span>
        </div>

        <div class="pull-right rating">
            <?= RatingWidget::widget(['rating' => $tour->rating]) ?>
        </div>
    </div>
</div>
