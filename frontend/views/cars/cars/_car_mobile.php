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
            <a href="<?= Html::encode($url) ?>">
                <img src="<?= Html::encode($car->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt=""
                     class="card-img-top"/>
            </a>
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
    <div class="card-body">
        <h4 class="card-title">
            <a href="<?= Html::encode($url) ?>"><?= Html::encode($car->getName()) ?></a>
        </h4>
        <p class="card-text" style="height: available">
        <div class="mb-auto text-justify">
            <?= (StringHelper::truncateWords(strip_tags($car->getDescription()), 20)) ?>
        </div>

        <div class="category-card pt-4">
            <?= implode(', ', ArrayHelper::map($car->cities, 'id', 'name')) ?>
        </div>

        </p>
    </div>
    <div class="mr-auto card-footer" style="border: 0 !important; background-color: white !important;">
        <a href="<?= Url::to(['/cars/category', 'id' => $car->type->id]) ?>"><?= Lang::t($car->type->name) ?></a>
    </div>
    <div class="mt-auto card-footer" style="background-color: #f6f7f5; border-color: #f6f7f5;">
        <div class="p-2">
            <span class="price-card"><?= CurrencyHelper::get($car->cost) ?></span>
        </div>
        <div class="pull-right rating">
            <?= RatingWidget::widget(['rating' => $car->rating]) ?>
        </div>
    </div>
</div>
