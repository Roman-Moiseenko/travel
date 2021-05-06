<?php

/* @var  $paid_locality bool*/
/* @var  $url string*/
use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="d2-btn-box">
    <button class="d2-btn d2-btn-wish" href="<?= Html::encode($url) ?>"
            type="button" data-toggle="tooltip"
            title="<?= Lang::t('В избранное') ?>"
            data-method="post">
            <i class="fa fa-heart"></i>
    </button>
</div>
