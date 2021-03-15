<?php
/* @var $legal \booking\entities\admin\Legal */

use booking\entities\admin\Legal;
use booking\entities\Lang;
use booking\helpers\SysHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$mobile = SysHelper::isMobile();
?>

<div class="row align-content-center">
    <div class="col-sm-6">
        <a href="<?= Url::to(['legals/view', 'id' => $legal->id]) ?>">
            <img src="<?= $legal->getThumbFileUrl('photo', $mobile ? 'profile_mobile' : 'profile_new'); ?>"
                 alt="<?= Html::encode($legal->getName()); ?>" title="<?= Html::encode($legal->getName()); ?>"
                 class="img-responsive"/>
        </a>
    </div>
    <div class="col-sm-6">
        <div class="py-2" style="font-size: 16px; color: #0b3e6f; font-weight: 600;"><?= $legal->getCaption() ?></div>
        <div class="py-2" style="font-size: 13px; color: #343434; font-weight: 500;"><?= $legal->getName() ?></div>
        <p class="pt-2"><a href="mailto:<?= $legal->noticeEmail ?>" class="btn badge-success"><?= Lang::t('Напишите нам')?></a>
    </div>
</div>
<div class="row align-content-center">
    <div class="col">
        <a href="<?= Url::to(['legals/view', 'id' => $legal->id]) ?>">
            <h5><?= '';// $mobile ? '' : Html::encode($legal->getCaption());  ?></h5></a>
    </div>

</div>
