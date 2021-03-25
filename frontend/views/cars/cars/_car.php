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

<div class="card p-0 my-3">
    <div class="card-body p-0">
        <div class="image-car-list"> <!-- style="position: relative" -->
            <div class="holder">
                <?php if ($car->mainPhoto): ?>
                    <div itemscope itemtype="https://schema.org/ImageObject">
                        <a href="<?= Html::encode($url) ?>">
                            <img src="<?= Html::encode($car->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>"
                                 alt="<?= $car->mainPhoto->getAlt() ?>"
                                 class="img-responsive" itemprop="contentUrl"/>
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
        </div>
        <div class="caption-car-list px-2">
            <div class="d-flex flex-column align-items-stretch" style="height: 228px">
                <div class="pt-3 text-center">
                    <a href="<?= Html::encode($url) ?>">
                        <h2 class="card-title card-object"><?= Html::encode($car->getName()) ?></h2>
                    </a>
                </div>

                <div class="mb-auto text-justify">
                    <?= (StringHelper::truncateWords(strip_tags($car->getDescription()), 20)) ?>
                </div>
                <div class="category-card pt-4">
                    <?= implode(', ', ArrayHelper::map($car->cities, 'id', 'name')) ?>
                </div>

                <div style="border: 0 !important; background-color: white !important;">
                    <a href="<?= Url::to(['/cars/category', 'id' => $car->type->id]) ?>"><?= Lang::t($car->type->name) ?></a>
                </div>
                <a href="<?= Html::encode($url) ?>">
                    <div class="color-card-footer margin-card-footer">
                        <div class="d-flex p-2">
                            <div class="pl-4 py-2">
                                <div class="price-card"><?= CurrencyHelper::get($car->cost) ?></div>
                                <span style="color: #3c3c3c; font-size: 12px"><?= Lang::t('за сутки') ?></span>
                            </div>
                            <div class="ml-auto">
                                <?= RatingWidget::widget(['rating' => $car->rating]) ?>
                                <span class="badge badge-success"><?= ($car->prepay == 0) ? Lang::t('без предоплаты') : ($car->prepay != 100 ? Lang::t('предоплата') . ' '. $car->prepay .'%' : '' ) ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
