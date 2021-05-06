<?php
use booking\entities\Lang;
/* @var $caption string */
/* @var $btn_id string */
/* @var $confirmation bool */


?>
<div class="d2-btn-box">
    <button class="d2-btn d2-btn-lg d2-btn-block d2-btn-main" type="submit" name="login-button">
        <div class="d2-btn-caption"><?= Lang::t('Войти') ?></div>
        <div class="d2-btn-icon">
            <i class="fas fa-sign-in-alt"></i>
        </div>
    </button>
</div>
