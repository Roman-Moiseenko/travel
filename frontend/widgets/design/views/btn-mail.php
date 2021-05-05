<?php

/* @var  $url string*/
/* @var  $caption string*/
use booking\entities\Lang;
use yii\helpers\Html;

?>

<div class="d2-btn-box">
    <a class="d2-btn d2-btn-block d2-btn-mail" href="<?= Html::encode($url) ?>">
        <?php if (!empty($caption)): ?><div class="d2-btn-caption"><?= Lang::t($caption)?></div><?php endif; ?>
        <div class="d2-btn-icon">
            <i class="far fa-envelope"></i>
        </div>
    </a>
</div>
