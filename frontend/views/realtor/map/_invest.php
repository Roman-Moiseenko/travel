<?php

use booking\entities\realtor\land\Land;
use booking\helpers\SysHelper;
use yii\helpers\Url;

/** @var $land Land */

$mobile = SysHelper::isMobile();
?>

<div class="card pt-4"  style="border: 0">
<div class="holder">
    <h2 class="pt-4"><?= $land->title ?></h2>
    <div class="item-responsive  <?= $mobile ? 'item-2-0by1' : 'item-3-0by1'?>">
        <div class="content-item">
            <img class="card-img-top" loading="lazy" src="<?= $land->getThumbFileUrl('photo', $mobile ? 'list_lands_mobile' : 'list_lands') ?>"/>
        </div>
    </div>
    <div class="params-moving" style="border: 0">

        <p class="pt-4"><?= $land->description ?></p>
        <p><a href="<?= Url::to(['realtor/map/view', 'slug' => $land->slug]) ?>"
              class="stretched-link">Подробнее об инвестиционном предложении</a>
        </p>
    </div>
</div>
</div>