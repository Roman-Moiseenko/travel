<?php

/* @var $times CostCalendar[] */

use booking\entities\booking\tours\CostCalendar;
use booking\entities\Lang;

?>
<div class="row pb-2">
    <div class="col-6">
        <label for="booking-fun-times"><b><?= Lang::t('Выберите время') ?>:</b></label>
        <select id="booking-fun-times" class="form-control">
            <option value="-1"></option>
            <?php foreach ($times as $calendar): ?>
                <option value="<?= $calendar->id ?>"><?= $calendar->time_at ?></option>
            <?php endforeach; ?>
        </select>
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