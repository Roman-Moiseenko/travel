<?php
use booking\entities\Lang;
use yii\helpers\Html;

/* @var  $url string*/
/* @var  $caption string*/
/* @var $block boolean */

?>

<div class="d2-btn-box">
    <a class="d2-btn <?= $block ? 'd2-btn-block' : '' ?> d2-btn-mail" href="<?= Html::encode($url) ?>">
        <?php if (!empty($caption)): ?><div class="d2-btn-caption"><?= Lang::t($caption)?></div><?php endif; ?>
        <div class="d2-btn-icon">
            <i class="fas fa-globe"></i>
        </div>
    </a>
</div>