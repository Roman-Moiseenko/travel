<?php
use booking\entities\Lang;
/* @var $caption string */
?>
<div class="d2-btn-box">
    <button class="d2-btn d2-btn-block d2-btn-main" type="submit">
        <?php if (!empty($caption)): ?> <div class="d2-btn-caption"><?= Lang::t($caption) ?></div><?php endif; ?>
        <div class="d2-btn-icon">
            <i class="far fa-paper-plane"></i>
            </div>
    </button>
</div>
