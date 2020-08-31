<?php
/* @var $rating integer */
?>
<div class="rating">
<?php for ($i = 1; $i <= 5; $i++): ?>
    <span class="fa fa-stack">
    <?php $star = 'far fa-star'; ?>
    <?php if ($i <= $rating) {
        $star = 'fas fa-star';
    } elseif ((0.20 < $i - $rating) && ($i - $rating < 0.80)) {
        $star = 'fas fa-star-half-alt';
    } ?>
        <i class="<?= $star; ?>"></i>
    </span>&nbsp
<?php endfor; ?>
</div>