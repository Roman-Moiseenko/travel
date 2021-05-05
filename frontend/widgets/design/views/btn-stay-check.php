<?php

/* @var  $caption string*/
/* @var  $url string*/
use booking\entities\Lang;
use yii\helpers\Html;

?>

<div class="d2-btn-box">
    <a class="d2-btn d2-btn-lg d2-btn-block d2-btn-main" href="<?= Html::encode($url) ?>">
        <div class="d2-btn-caption"><?= Lang::t($caption) ?></div>
        <div class="d2-btn-icon">
            <i class="fas fa-angle-double-right"></i>
        </div>
    </a>
</div>
