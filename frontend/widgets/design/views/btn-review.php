<?php
use booking\entities\Lang;
/* @var $caption string */

/* @var $classes array */
/* @var $target_id string */

?>

<div class="d2-btn-box">
    <button type="button" class="d2-btn d2-btn-block d2-btn-empty"
            data-toggle="collapse"
            data-target="#<?= $target_id ?>"
            aria-expanded="false" aria-controls="<?= $target_id ?>">
        <?php if (!empty($caption)):?><div class="d2-btn-caption"><?= Lang::t($caption) ?></div><?php endif; ?>
        <div class="d2-btn-icon">
            <i class="fas fa-pen"></i>
        </div>
    </button>
</div>
