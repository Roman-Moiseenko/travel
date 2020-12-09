<?php

use booking\entities\booking\funs\CostCalendar;

/* @var $this yii\web\View */
/* @var $calendars CostCalendar[] */

?>
<div class="row pb-2">
    <div class="col">
        <input type="hidden" value=""/>
        <label for="selling-tour-time"><b><?= 'Выберите время' ?>:</b></label>
        <select id="selling-tour-time" name="calendar_id" class="form-control">
            <option value="-1"></option>
            <?php foreach ($calendars as $calendar): ?>
                <option value="<?= $calendar->id ?>"><?= $calendar->time_at ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div id="list-count"></div>

