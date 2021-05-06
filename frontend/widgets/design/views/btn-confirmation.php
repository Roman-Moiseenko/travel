<?php
use booking\entities\Lang;
/* @var $caption string */
/* @var $btn_id string */
/* @var $confirmation bool */


?>
<div class="d2-btn-box">
    <button class="d2-btn d2-btn-block d2-btn-main" type="submit">
        <div class="d2-btn-caption"><?= Lang::t('Подтвердить') ?></div>
        <div class="d2-btn-icon">
            <i class="fas fa-check-double"></i>
        </div>
    </button>
</div>
