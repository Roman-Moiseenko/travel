<?php

/* @var $calendar_json string */

use booking\entities\Lang;

?>
<div class="row pb-2">
    <div class="col-sm-12">
        <label for="booking-fun-times"><b><?= Lang::t('Выберите время') ?>:</b></label>
        <div id="multi-timer" data-calendar="<?= $calendar_json ?>"></div>
    </div>
</div>
<div class="row pb-2">
    <div class="col">
        <div class="tickets-funs"></div>
    </div>
</div>
<div class="row pb-2">
    <div class="col">
        <div class="errors-funs"></div>
    </div>
</div>