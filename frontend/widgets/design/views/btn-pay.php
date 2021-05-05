<?php

/* @var  $paid_locality bool*/
/* @var  $url string*/
use booking\entities\Lang;
use yii\helpers\Html;

?>

<div class="d2-btn-box">
    <a class="d2-btn d2-btn-block d2-btn-main" href="<?= Html::encode($url) ?>">
        <div class="d2-btn-caption"><?= $paid_locality ? Lang::t('Подтвердить') : Lang::t('Оплатить') ?></div>
        <div class="d2-btn-icon">
            <?= !$paid_locality ? '<i class="fas fa-credit-card"></i>' : '<i class="fas fa-check-double"></i>'?>
        </div>
    </a>
</div>
