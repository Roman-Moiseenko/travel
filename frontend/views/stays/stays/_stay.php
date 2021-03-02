<?php

use booking\entities\booking\stays\Stay;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use frontend\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $stay Stay */
?>

<?php $url = Url::to(['/stay/view', 'id' => $stay->id]) ?>

<div class="card p-0 my-3">
    <div class="card-body p-0">
        <div class="image-stay-list" > <!-- style="position: relative" -->
            <div class="holder">
            <?php if ($stay->mainPhoto): ?>
                <div itemscope itemtype="http://schema.org/ImageObject">
                    <a href="<?= Html::encode($url) ?>">
                        <img src="<?= Html::encode($stay->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt=""
                             class="img-responsive" itemprop="contentUrl"/>
                    </a>
                    <meta itemprop="name" content="Аренда жилья в Калининграде">
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
        </div>
        <div class="caption-car-list px-2">
            <div class="d-flex flex-column align-items-stretch" style="height: 228px">
                <div class="pt-3 text-center">
                    <h4 class="card-title card-object">
                        <a href="<?= Html::encode($url) ?>"><?= Html::encode($stay->getName()) ?></a>
                    </h4>
                </div>
                <div class="mb-auto text-justify">
                    <?= (StringHelper::truncateWords(strip_tags($stay->getDescription()), 20)) ?>
                </div>
                <div class="category-card pt-4">
                    <?= $stay->city ?>
                </div>

                <div style="border: 0 !important; background-color: white !important;">
                    <a href="<?= Url::to(['/stays/category', 'id' => $stay->type->id]) ?>"><?= Lang::t($stay->type->name) ?></a>
                </div>
                <a href="<?= Html::encode($url) ?>">
                    <div class="color-card-footer margin-card-footer">
                    <div class="pl-4 py-2">
                        <?php //TODO Вычесление стоимости в зависимости от гостей!!!!!!!! ?>
                        <span class="price-card"><?= CurrencyHelper::get($stay->cost_base) ?></span>
                    </div>
                    <div class="pull-right rating pl-4 pb-2">
                        <?= RatingWidget::widget(['rating' => $stay->rating]) ?>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>
