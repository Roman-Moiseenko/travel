<?php
/* @var $legal \booking\entities\admin\UserLegal */

use booking\entities\admin\UserLegal;
use yii\helpers\Html;
use yii\helpers\Url; ?>

<div class="row align-content-center">
    <div class="col-12"><a href="<?=Url::to(['legals/view', 'id' => $legal->id])?>">
    <img src="<?= $legal->getThumbFileUrl('photo', 'cart_list'); ?>"
         alt="<?= Html::encode($legal->name); ?>"/>
    </a>
    </div>
</div>
<div class="row align-content-center">
    <div class="col-12">
    <a href="<?=Url::to(['legals/view', 'id' => $legal->id])?>"><h5><?= Html::encode($legal->caption); ?></h5></a>
    </div>
</div>
