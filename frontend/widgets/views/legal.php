<?php
/* @var $legal \booking\entities\admin\Legal */

use booking\entities\admin\Legal;
use yii\helpers\Html;
use yii\helpers\Url; ?>

<div class="row align-content-center">
    <div class="col-12"><a href="<?=Url::to(['legals/view', 'id' => $legal->id])?>">
    <img src="<?= $legal->getThumbFileUrl('photo', 'profile'); ?>"
         alt="<?= Html::encode($legal->name); ?>" class="img-responsive"/>
    </a>
    </div>
</div>
<div class="row align-content-center">
    <div class="col-12">
    <a href="<?=Url::to(['legals/view', 'id' => $legal->id])?>"><h5><?= Html::encode($legal->caption); ?></h5></a>
    </div>
</div>
