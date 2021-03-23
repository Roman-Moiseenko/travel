<?php
/* @var $legal \booking\entities\admin\Legal */

use booking\entities\admin\Legal;
use booking\entities\Lang;
use booking\helpers\SysHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$mobile = SysHelper::isMobile();
if (!empty($legal->photo)) {
    $photoLegal = $legal->getThumbFileUrl('photo', $mobile ? 'profile_mobile' : 'profile_new');
} else {
    $photoLegal = $mobile ?
        \Yii::$app->params['staticHostInfo'] . '/files/images/no_photo_mobile.jpg' :
        \Yii::$app->params['staticHostInfo'] . '/files/images/no_photo.jpg';
}
?>

<div class="row align-content-center">
    <div class="col-sm-6">
        <a href="<?= Url::to(['legals/view', 'id' => $legal->id]) ?>">
            <img src="<?= $photoLegal; ?>"
                 alt="<?= Html::encode($legal->getName()); ?>" title="<?= Html::encode($legal->getName()); ?>"
                 class="img-responsive"/>
        </a>
    </div>
    <div class="col-sm-6">
        <a href="<?= Url::to(['legals/view', 'id' => $legal->id]) ?>"><div class="py-2" style="font-size: 16px; color: #0b3e6f; font-weight: 600;"><?= $legal->getCaption() ?></div>
            <div class="py-2" style="font-size: 13px; color: #343434; font-weight: 500;"><?= $legal->getName() ?></div></a>
        <p class="pt-2"><a href="mailto:<?= $legal->noticeEmail ?>" class="btn badge-success"><?= Lang::t('Напишите нам')?></a>
    </div>
</div>
<div class="row align-content-center">
    <div class="col">
        <a href="<?= Url::to(['legals/view', 'id' => $legal->id]) ?>">
            <h5><?= '';// $mobile ? '' : Html::encode($legal->getCaption());  ?></h5></a>
    </div>

</div>
