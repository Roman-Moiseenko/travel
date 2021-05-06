<?php

/* @var  $paid_locality bool*/
/* @var  $url string*/
use booking\entities\Lang;
use yii\helpers\Html;

?>

<div class="d2-btn-box">
    <a class="d2-btn d2-btn-mail" href="<?= Html::encode($url) ?>">
        <div class="d2-btn-caption"><?= Lang::t('Перейти в корзину') ?></div>
        <div class="d2-btn-icon">
            <i class="fa fa-shopping-cart"></i>
        </div>
    </a>
</div>
