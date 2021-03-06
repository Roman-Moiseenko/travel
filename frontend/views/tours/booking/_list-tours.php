<?php

/* @var $day_tours CostCalendar[] */

use booking\entities\booking\tours\CostCalendar;
use booking\entities\Lang;

?>
<div class="row pb-2">
    <div class="col-6">
        <input type="hidden" value=""/>
        <label for="booking-tour-time"><b><?= Lang::t('Выберите время') ?>:</b></label>
        <select id="booking-tour-time" name="calendar_id" class="form-control">
            <option value="-1"></option>
            <?php foreach ($day_tours as $calendar): ?>
                <option value="<?= $calendar->id ?>"><?= $calendar->time_at ?></option>
            <?php endforeach; ?>
        </select>

    </div>
</div>
<div class="row pb-2">
    <div class="col">
        <div class="tickets-tours"></div>
    </div>
</div>
<div class="row pb-2">
    <div class="col">
        <div class="errors-tours"></div>
    </div>
</div>