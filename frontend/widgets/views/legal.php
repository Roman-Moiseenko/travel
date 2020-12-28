<?php
/* @var $legal \booking\entities\admin\Legal */

use booking\entities\admin\Legal;
use booking\helpers\SysHelper;
use yii\helpers\Html;
use yii\helpers\Url;
$mobile = SysHelper::isMobile();
?>

<div class="row align-content-center">
    <div class="col-12"><a href="<?=Url::to(['legals/view', 'id' => $legal->id])?>">
    <img src="<?= $legal->getThumbFileUrl('photo', $mobile ? 'profile_mobile' : 'profile'); ?>"
         alt="<?= Html::encode($legal->getName()); ?>" title="<?= Html::encode($legal->getName()); ?>" class="img-responsive"/>
    </a>
    </div>
</div>
<div class="row align-content-center">
    <div class="col-12">
    <a href="<?=Url::to(['legals/view', 'id' => $legal->id])?>"><h5><?= '';// $mobile ? '' : Html::encode($legal->getCaption()); ?></h5></a>
    </div>
</div>
