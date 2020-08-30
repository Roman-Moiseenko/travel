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



<?php $url = Url::to(['/tours/view', 'id' => $tour->id])?>
<div class="product-layout product-list col-12">
    <div class="product-thumb">
        <?php if ($tour->mainPhoto): ?>
            <div class="image">
                <a href="<?=Html::encode($url)?>">
                    <img src="<?=Html::encode($tour->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt="" class="img-responsive" />
                </a>
            </div>
        <?php endif; ?>
        <div class="caption">
            <h4>
                <a href="<?= Html::encode($url) ?>"><?= Html::encode($tour->name) ?></a>
                <button type="button" data-toggle="tooltip" title="<?= Lang::t('В избранное')?>" href="<?= Url::to(['/cabinet/wishlist/add-tour', 'id' => $tour->id]) ?>" data-method="post"><i class="fa fa-heart"></i></button>
            </h4>

            <p><?= Html::encode(StringHelper::truncateWords(strip_tags($tour->description), 10)) ?></p>
            <p class="price">
                <span class="price-new"><?= CurrencyHelper::get($tour->baseCost->adult) ?></span>
            </p>
            <p>
            <div class="pull-left price">

                <?php foreach ($tour->types as $type): ?>
                 <?= Lang::t($type->name) . ' | ';?>
                <?php endforeach;?>
                <?= Lang::t($tour->type->name) ?>
            </div>
            <div class="pull-right rating">
                <?= RatingWidget::widget(['rating' => $tour->rating])?>
            </div>
            </p>
        </div>

    </div>
</div>
