<?php

/* @var  $paid_locality bool*/
/* @var  $url string*/
/* @var  $caption string*/
use booking\entities\Lang;
use yii\helpers\Html;

?>

<div class="d2-btn-box">
    <a class="d2-btn d2-btn-cancel" href="<?= Html::encode($url) ?>">
        <div class="d2-btn-caption"><?= Lang::t($caption) ?></div>
        <div class="d2-btn-icon">
            <i class="fas fa-times"></i>
        </div>
    </a>
</div>
