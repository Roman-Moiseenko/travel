<?php

use booking\entities\realtor\Landowner;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $landowner Landowner */

$mobile = SysHelper::isMobile();


?>

<?php $url = Url::to(['/realtor/landowners/view', 'id' => $landowner->id]) ?>

<div class="card mb-3 p-2" style="border: 0 !important; ">
    <div class="holder"> <!-- style="position: relative" -->
        <?php if ($landowner->mainPhoto): ?>
            <div itemscope itemtype="https://schema.org/ImageObject">
                <div class="item-responsive <?= $mobile ? 'item-2-0by1' : 'item-1-1by1'?>">
                    <div class="content-item">
                        <a href="<?= Html::encode($url) ?>">
                            <img loading="lazy" src="<?= Html::encode($landowner->mainPhoto->getThumbFileUrl('file', $mobile ? 'catalog_list_mobile' : 'catalog_list')) ?>"
                                 alt="<?= $landowner->mainPhoto->getAlt() ?>"
                                 title="<?= $landowner->name ?>"
                                 class="card-img-top lazyload"/>
                            <link  itemprop="contentUrl" href="<?= Html::encode($landowner->mainPhoto->getThumbFileUrl('file', $mobile ? 'catalog_list_mobile' : 'catalog_list')) ?>">
                        </a>
                    </div>
                </div>
                <meta itemprop="name"
                      content="<?= empty($landowner->mainPhoto->alt) ? 'Земельные участки в Калининграде' : $landowner->mainPhoto->getAlt() ?>">
                <meta itemprop="description" content="<?= $landowner->name ?>">
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body color-card-body">
        <a href="<?= Html::encode($url) ?>">
            <h2 class="card-title card-object"><?= Html::encode($landowner->name) ?></h2>
        </a>
        <p class="card-text" style="height: available">
        <div class="mb-auto text-justify" style="font-size: 1.2rem">
            <?= $landowner->description ?>
        </div>
        </p>
    </div>
    <div class="card-footer color-card-body">
        <p class="landowner-description"><i class="fas fa-arrow-alt-circle-up"></i> <?= $landowner->count ?> участков</p>
        <p class="landowner-description"><i class="fas fa-chart-area"></i> от <?= $landowner->size ?> соток</p>
        <p class="landowner-description"><i class="fas fa-coins"></i> от <?= CurrencyHelper::stat($landowner->cost) ?> за сотку</p>
        <p class="landowner-description"><i class="fas fa-road"></i> <?= $landowner->distance ?> км до Калининграда</p>
    </div>
</div>