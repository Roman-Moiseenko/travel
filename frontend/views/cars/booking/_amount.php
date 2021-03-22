<?php

use booking\helpers\CurrencyHelper;

/* @var $full_cost float */
/* @var $prepay float */
/* @var $percent integer */

?>

<div class="row pt-4 pb-2">
    <div class="col-6 pr-1">
        <span style="font-size: 14px; font-weight: 600;">ИТОГО:</span>
    </div>
    <div class="col-6 px-1" data-amount="<?= 0 ?>">
        <span class="badge badge-success" style="font-size: 18px; font-weight: 600;"><?= $full_cost == 0 ? '-' : CurrencyHelper::cost($full_cost) ?></span>
    </div>
</div>
<div class="row pb-2">
    <div class="col-6 pr-1">
        <span style="font-size: 12px; font-weight: 600;">Предоплата (<?= $percent ?>%):</span>
    </div>
    <div class="col-6 px-1" data-amount="<?= 0 ?>">
        <span class="badge badge-success" style="font-size: 18px; font-weight: 600;"><?= $prepay == 0 ? '-' : CurrencyHelper::cost($prepay) ?></span>
    </div>
</div>