<?php

use booking\entities\CheckClickUser;
use booking\entities\Lang;
use yii\helpers\Html;

/* @var  $phone string*/
/* @var  $caption string*/
/* @var  $class string*/
/* @var $block boolean */
/* @var $class_name_click string */
/* @var $class_id_click integer */
?>

<div class="d2-btn-box">
    <a class="d2-btn <?= ($block ? 'd2-btn-block' : ''). ' ' . $class ?>" href="tel:<?= $phone ?>" rel="nofollow"
       data-class-name="<?=$class_name_click?>" data-class-id="<?=$class_id_click?>" data-type-event="<?= CheckClickUser::CLICK_PHONE ?>">
        <?php if (!empty($caption)): ?><div class="d2-btn-caption"><?= Lang::t($caption)?></div><?php endif; ?>
        <div class="d2-btn-icon">
            <i class="fas fa-phone"></i>
        </div>
    </a>
</div>