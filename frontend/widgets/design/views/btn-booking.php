<?php
use booking\entities\Lang;
/* @var $caption string */
/* @var $btn_id string */
/* @var $confirmation bool */


?>
<div class="d2-btn-box">
    <button class="d2-btn d2-btn-lg d2-btn-block d2-btn-main" type="submit" id="<?= $btn_id ?>" disabled>
        <?php if (!empty($caption)): ?> <div class="d2-btn-caption"><?= Lang::t($caption) ?></div><?php endif; ?>
        <div class="d2-btn-icon">
            <?= $confirmation ? '<i class="fas fa-check-double"></i>' : '<i class="fas fa-credit-card"></i>' ?>
            </div>
    </button>
</div>
