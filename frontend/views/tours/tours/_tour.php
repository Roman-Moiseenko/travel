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

<?php $url = Url::to(['/tour/view', 'id' => $tour->id]) ?>

<div class="card mb-3 p-2" style="border: 0 !important; ">
    <div class="holder"> <!-- style="position: relative" -->
        <?php if ($tour->mainPhoto): ?>
            <a href="<?= Html::encode($url) ?>">
                <img src="<?= Html::encode($tour->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt=""
                     class="card-img-top"/>
            </a>
        <?php endif; ?>
        <div class="block-wishlist">
            <button type="button" data-toggle="tooltip" class="btn btn-default btn-wish"
                    title="<?= Lang::t('В избранное') ?>"
                    href="<?= Url::to(['/cabinet/wishlist/add-tour', 'id' => $tour->id]) ?>"
                    data-method="post">
                <i class="fa fa-heart"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <h4 class="card-title">
            <a href="<?= Html::encode($url) ?>"><?= Html::encode($tour->name) ?></a>
        </h4>
        <p class="card-text" style="height: available">
        <div class="mb-auto">
            <?= Html::encode(StringHelper::truncateWords(strip_tags($tour->description), 20)) ?>
        </div>
        <div class="category-card pt-4">

        </div>
        </p>
    </div>
    <div class="mr-auto card-footer" style="border: 0 !important; background-color: white !important;">
        <?php foreach ($tour->types as $type): ?>
            <a href="<?= Url::to(['/tours/category', 'id' => $type->id])?>"><?= Lang::t($type->name) ?></a>&#160;|&#160;
        <?php endforeach; ?>
        <a href="<?= Url::to(['/tours/category', 'id' => $tour->type->id])?>"><?= Lang::t($tour->type->name) ?></a>
    </div>
    <div class="mt-auto card-footer" style="background-color: #f6f7f5; border-color: #f6f7f5;">
        <div class="p-2">
            <span class="price-card"><?= CurrencyHelper::get($tour->baseCost->adult) ?></span>
        </div>
        <div class="pull-right rating">
            <?= RatingWidget::widget(['rating' => $tour->rating]) ?>
        </div>
    </div>
</div>
