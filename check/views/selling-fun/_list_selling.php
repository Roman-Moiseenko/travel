<?php
/* @var $max_count int */

use booking\entities\booking\funs\SellingFun;
use booking\helpers\BookingHelper;

/* @var $sales SellingFun[] */
/* @var $error string */
?>

<div class="row pb-2">
    <div class="col-6">
        <input type="number" id="selling-count" min="1" value="1"  class="form-control">
    </div>
    <div class="col-2">
        <a id="selling-add" class="btn"><i class="fas fa-plus-circle" style="color: green"></i></a>
    </div>
</div>
<?php if ($error != ''): ?>
<div class="row">
    <div class="col">
        <span class="badge badge-danger"><?=$error ?></span>
    </div>
</div>
<?php endif; ?>
<div class="row pb-2">
    <div class="col">
        <?php foreach ($sales as $sale): ?>
            <?= date('d-m H:s', $sale->created_at) . '&#160;&#160;&#160;' .
                BookingHelper::icons(BookingHelper::BOOKING_TYPE_FUNS) . ' ' .
                $sale->count ?> <a id="selling-remove" class="btn" data-id="<?= $sale->id?>"><i class="fas fa-times" style="color: red"></i></a><br>
        <?php endforeach; ?>
    </div>
</div>


