<?php

/* @var  $paid_locality bool*/
/* @var  $url string*/
use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="d2-btn-box">
    <a class="d2-btn d2-btn-lg d2-btn-block d2-btn-main" href="<?= Html::encode($url) ?>" data-method="POST" data-params='{"prepare":true}'>
        <div class="d2-btn-caption"><?= Lang::t('Оформить заказ') ?></div>
        <div class="d2-btn-icon">
            <i class="fas fa-box-open"></i>
        </div>
    </a>
</div>
