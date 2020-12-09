<?php

use booking\entities\booking\cars\CostCalendar;
/* @var $this yii\web\View */
/* @var $calendars CostCalendar[] */

?>
<div class="row pb-2">
    <div class="col">
        <input type="hidden" value=""/>
        <label for="selling-car-time"><b><?= 'Выберите время' ?>:</b></label>
        <select id="selling-car-time" name="calendar_id" class="form-control">
            <option value="-1"></option>
            <?php foreach ($calendars as $calendar): ?>
                <option value="<?= $calendar->id ?>"><?= $calendar->time_at ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div id="list-count"></div>

