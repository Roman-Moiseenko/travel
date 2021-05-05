<?php
use booking\entities\Lang;
/* @var $not_caption bool */
?>

<div class="d2-btn-box">
    <button type="submit" class="d2-btn d2-btn-block d2-btn-main">
        <?php if (!$not_caption):?><div class="d2-btn-caption"><?= Lang::t('Найти') ?></div><?php endif; ?>
        <div class="d2-btn-icon">
            <i class="fas fa-search"></i>
        </div>
    </button>
</div>
