<?php

/* @var $day_tours CostCalendar[] */

use booking\entities\booking\tours\CostCalendar;

?>
<div class="row">
    <div class="col-6">
        <input type="hidden" value=""/>
        <label for="booking-tour-time">Выберите время:</label>
        <select id="booking-tour-time" class="form-control">
            <option value="-1"></option>
            <?php foreach ($day_tours as $calendar): ?>
                <option value="<?= $calendar->id ?>"><?= $calendar->time_at ?></option>
            <?php endforeach; ?>
        </select>

    </div>
</div>
<div class="row">
    <div class="tickets-tours"></div>
    <div class="errors-tours"></div>
</div>