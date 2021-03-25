<?php

use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
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
