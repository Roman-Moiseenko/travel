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
            <div itemscope itemtype="https://schema.org/ImageObject">
                <a href="<?= Html::encode($url) ?>">
                    <img src="<?= Html::encode($fun->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt="<?= Lang::t($fun->mainPhoto->alt) ?>"
                         class="card-img-top" itemprop="contentUrl"/>
                </a>
                <meta itemprop="name" content="<?= empty($fun->mainPhoto->alt) ? 'Развлечения и отдых в Калининграде' : Lang::t($tour->mainPhoto->alt) ?>">
                <meta itemprop="description" content="<?= $fun->getName() ?>">
            </div>
        <?php endif; ?>
        <div class="block-wishlist">
            <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
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
    <div class="card-body color-card-body">
        <a href="<?= Html::encode($url) ?>">
            <h2 class="card-title card-object">
                <?= Html::encode($fun->getName()) ?>
            </h2>
        </a>
        <p class="card-text" style="height: available">
        <div class="mb-auto text-justify">
            <?= (StringHelper::truncateWords(strip_tags($fun->getDescription()), 20)) ?>
        </div>

        </p>
    </div>
    <div class="card-footer color-card-body">
        <a href="<?= Url::to(['/funs/category', 'id' => $fun->type->id]) ?>"><?= Lang::t($fun->type->name) ?></a>
    </div>
    <a href="<?= Html::encode($url) ?>">
    <div class="mt-auto card-footer color-card-footer">
        <div class="p-2">
            <span class="price-card"><?= CurrencyHelper::get($fun->baseCost->adult) ?></span>
        </div>
        <div class="pull-right rating">
            <?= RatingWidget::widget(['rating' => $fun->rating]) ?>
        </div>
    </div>
    </a>
</div>
