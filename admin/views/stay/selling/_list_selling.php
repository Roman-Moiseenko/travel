<?php
/* @var $max_count int */

use booking\entities\booking\stays\CostCalendar;
use booking\entities\booking\stays\SellingStay;
use booking\helpers\BookingHelper;

/* @var $sales SellingStay[] */
/* @var $error string */
/* @var $calendar_id CostCalendar */
?>
<div id="calendar-id" data-id="<?= $calendar_id ?>"
<?php if ($calendar_id != null && count($sales) == 0): ?>
<div class="row pb-2">
    <div class="col-6">
        <input type="number" id="selling-count" min="1" value="1"  class="form-control">
    </div>
    <div class="col-2">
        <a id="selling-add" class="btn"><i class="fas fa-plus-circle" style="color: green"></i></a>
    </div>
</div>
<?php endif; ?>
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
            <?= date('d-m H:i', $sale->created_at) . '&#160;&#160;&#160;' .
                BookingHelper::icons(BookingHelper::BOOKING_TYPE_STAY) . ' ' .
                $sale->count ?> <a id="selling-remove" class="btn" data-id="<?= $sale->id?>"><i class="fas fa-times" style="color: red"></i></a><br>
        <?php endforeach; ?>
    </div>
</div>


