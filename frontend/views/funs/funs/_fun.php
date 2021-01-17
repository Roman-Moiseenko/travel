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
                <div itemscope itemtype="http://schema.org/ImageObject">
                    <a href="<?= Html::encode($url) ?>">
                        <img src="<?= Html::encode($fun->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt=""
                             class="img-responsive" itemprop="contentUrl"/>
                    </a>
                    <meta itemprop="name" content="Развлечения и отдых в Калининграде">
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
                    <h4 class="card-title card-object">
                        <a href="<?= Html::encode($url) ?>"><?= Html::encode($fun->getName()) ?></a>
                    </h4>
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
                <div style="background-color: #f6f7f5; border-color: #f6f7f5; margin-left: -6px !important; margin-right: -6px !important;">
                    <div class="pl-4 py-2">
                        <span class="price-card"><?= CurrencyHelper::get($fun->baseCost->adult) ?></span>
                    </div>
                    <div class="pull-right rating pl-4 pb-2">
                        <?= RatingWidget::widget(['rating' => $fun->rating]) ?>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>
