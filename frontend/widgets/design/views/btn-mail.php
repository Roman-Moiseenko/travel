<?php

/* @var  $url string*/
/* @var  $caption string*/
/* @var $class_name_click string */
/* @var $class_id_click integer */

use booking\entities\CheckClickUser;
use booking\entities\Lang;
use yii\helpers\Html;

?>

<div class="d2-btn-box">
    <a class="d2-btn <?= $block ? 'd2-btn-block' : '' ?> d2-btn-mail" href="<?= Html::encode($url) ?>" rel="nofollow"
       data-class-name="<?=$class_name_click?>" data-class-id="<?=$class_id_click?>" data-type-event="<?= CheckClickUser::CLICK_EMAIL ?>">
        <?php if (!empty($caption)): ?><div class="d2-btn-caption"><?= Lang::t($caption)?></div><?php endif; ?>
        <div class="d2-btn-icon">
            <i class="far fa-envelope"></i>
        </div>
    </a>
</div>
