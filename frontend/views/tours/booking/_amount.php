<?php

use booking\entities\Lang;
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
        <span class="amount-booking"><?= $full_cost == 0 ? '-' : CurrencyHelper::get($full_cost, false) ?></span>
    </div>
</div>
<div class="row pb-2">
    <div class="col-6 pr-1">
        <span style="font-size: 12px; font-weight: 600;"><?= Lang::t('Предоплата') . '(' . $percent . '%):' ?></span>
    </div>
    <div class="col-6 px-1" data-amount="<?= 0 ?>">
        <span class="amount-booking"><?= $prepay == 0 ? '-' : CurrencyHelper::get($prepay, false) ?></span>
    </div>
</div>
