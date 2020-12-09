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
        <div class="image-car-list" > <!-- style="position: relative" -->
            <div class="holder">
            <?php if ($car->mainPhoto): ?>
                <a href="<?= Html::encode($url) ?>">
                    <img src="<?= Html::encode($car->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt=""
                         class="img-responsive"/>
                </a>
            <?php endif; ?>
            <div class="block-wishlist">
                <button type="button" data-toggle="tooltip" class="btn btn-default btn-wish"
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
                    <h4 class="card-title">
                        <a href="<?= Html::encode($url) ?>"><?= Html::encode($car->getName()) ?></a>
                    </h4>
                </div>
                <div class="mb-auto text-justify">
                    <?= Html::encode(StringHelper::truncateWords(strip_tags($car->getDescription()), 20)) ?>
                </div>
                <div class="category-card pt-4">
                    <?= implode(', ', ArrayHelper::map($car->cities, 'id', 'name')) ?>
                </div>

                <div style="border: 0 !important; background-color: white !important;">
                    <a href="<?= Url::to(['/cars/category', 'id' => $car->type->id]) ?>"><?= Lang::t($car->type->name) ?></a>
                </div>

                <div style="background-color: #f6f7f5; border-color: #f6f7f5; margin-left: -6px !important; margin-right: -6px !important;">
                    <div class="pl-4 py-2">
                        <span class="price-card"><?= CurrencyHelper::get($car->cost) ?></span>
                    </div>
                    <div class="pull-right rating pl-4 pb-2">
                        <?= RatingWidget::widget(['rating' => $car->rating]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
