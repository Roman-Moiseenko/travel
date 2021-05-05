<?php

/* @var  $paid_locality bool*/
/* @var  $url string*/
use booking\entities\Lang;
use yii\helpers\Html;

?>

<div class="d2-btn-box">
    <a class="d2-btn d2-btn-lg d2-btn-block d2-btn-main" href="<?= Html::encode($url) ?>">
        <div class="d2-btn-caption"><?= Lang::t('Где купить') ?></div>
        <div class="d2-btn-icon">
            <i class="fas fa-store"></i>
        </div>
    </a>
</div>
