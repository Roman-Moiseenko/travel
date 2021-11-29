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
<a href="<?= Html::encode($url) ?>"><h2 class="pt-4"><?= $landowner->title ?></h2></a>

        <?php if ($landowner->mainPhoto): ?>
            <div itemscope itemtype="https://schema.org/ImageObject">
                <div class="item-responsive item-3-0by1">
                    <div class="content-item">
                        <a href="<?= Html::encode($url) ?>">
                            <img loading="lazy" src="<?= Html::encode($landowner->mainPhoto->getThumbFileUrl('file', 'catalog_gallery_3x')) ?>"
                                 alt="<?= $landowner->mainPhoto->getAlt() ?>"
                                 title="<?= $landowner->name ?>"
                                 class="card-img-top lazyload"/>
                            <link  itemprop="contentUrl" href="<?= Html::encode($landowner->mainPhoto->getThumbFileUrl('file', 'catalog_gallery_3x')) ?>">
                        </a>
                    </div>
                </div>
                <meta itemprop="name"
                      content="<?= empty($landowner->mainPhoto->alt) ? 'Земельные участки в Калининграде' : $landowner->mainPhoto->getAlt() ?>">
                <meta itemprop="description" content="<?= $landowner->name ?>">
            </div>
        <?php endif; ?>
        <p class="params-moving">
            <?= $landowner->description ?>
        </p>

<p class="params-moving">
    <a href="<?= Html::encode($url) ?>">Подробнее ...</a>

</p>
