<?php

use booking\entities\booking\tours\CostCalendar;

/* @var $day_tours CostCalendar[] */
/* @var $D integer */
/* @var $M integer */
/* @var $Y integer */
/* @var $errors array */
?>

<div class="card card-info" style="max-width: 400px; width: calc(100vw - 40px)">
    <div id="data-day" data-d="<?= $D ?>" data-m="<?= $M ?>" data-y="<?= $Y ?>"></div>
    <div class="card-header"><span style="font-size: larger; font-weight: bold">На <?= $D ?> число</span></div>
    <div class="card-body p-1">
        <?php if (isset($errors) && isset($errors['del-day'])): ?>
            <div class="row">
                <div class="col-12">
                    <span style="font-size: larger; font-weight: bold; color: #c12e2a"><?= $errors['del-day'] ?></span>
                </div>
            </div>
        <?php endif; ?>
        <?php foreach ($day_tours as $costCalendar): ?>
            <div class="row">
                <div class="col-12 calendar-tour-day-info">
                    <i class="fas fa-clock"></i>&nbsp;<?= $costCalendar->time_at ?>&nbsp;
                    <i class="fas fa-ticket-alt"></i>&nbsp;<?= $costCalendar->tickets ?>&nbsp;
                    <i class="fas fa-ruble-sign"></i>&nbsp;<?= $costCalendar->cost->adult ?>
                    /<?= $costCalendar->cost->child ?? '--' ?>/<?= $costCalendar->cost->preference ?? '--' ?>&nbsp;
                    <a href="#" class="btn del-day" data-id="<?= $costCalendar->id ?>" style="display: inline !important; width: available !important;"><i class="fas fa-times"
                                                                                      style="color: red"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


