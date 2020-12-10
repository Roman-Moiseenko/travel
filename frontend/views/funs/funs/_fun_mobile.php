<?php

use booking\entities\booking\funs\Fun;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $fun Fun */
?>

<?php $url = Url::to(['/fun/view', 'id' => $fun->id]) ?>

<div class="card mb-3 p-2" style="border: 0 !important; ">
    <div class="holder"> <!-- style="position: relative" -->
        <?php if ($fun->mainPhoto): ?>
            <a href="<?= Html::encode($url) ?>">
                <img src="<?= Html::encode($fun->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt=""
                     class="card-img-top"/>
            </a>
        <?php endif; ?>
        <div class="block-wishlist">
            <button type="button" data-toggle="tooltip" class="btn btn-default btn-wish"
                    title="<?= Lang::t('В избранное') ?>"
                    href="<?= Url::to(['/cabinet/wishlist/add-fun', 'id' => $fun->id]) ?>"
                    data-method="post">
                <i class="fa fa-heart"></i>
            </button>
        </div>
        <?php if ($fun->isNew()): ?>
            <div class="new-object-booking"><span class="new-text">new</span></div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <h4 class="card-title">
            <a href="<?= Html::encode($url) ?>"><?= Html::encode($fun->getName()) ?></a>
        </h4>
        <p class="card-text" style="height: available">
        <div class="mb-auto text-justify">
            <?= Html::encode(StringHelper::truncateWords(strip_tags($fun->getDescription()), 20)) ?>
        </div>

        </p>
    </div>
    <div class="mr-auto card-footer" style="border: 0 !important; background-color: white !important;">
        <a href="<?= Url::to(['/funs/category', 'id' => $fun->type->id]) ?>"><?= Lang::t($fun->type->name) ?></a>
    </div>
    <div class="mt-auto card-footer" style="background-color: #f6f7f5; border-color: #f6f7f5;">
        <div class="p-2">
            <span class="price-card"><?= CurrencyHelper::get($fun->baseCost->adult) ?></span>
        </div>
        <div class="pull-right rating">
            <?= RatingWidget::widget(['rating' => $fun->rating]) ?>
        </div>
    </div>
</div>