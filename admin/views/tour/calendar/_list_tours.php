<?php

use booking\entities\booking\tours\CostCalendar;

/* @var $day_tours CostCalendar[] */
/* @var $D integer */
/* @var $M integer */
/* @var $Y integer */
/* @var $errors array */
?>
<div id="data-day" data-d="<?= $D ?>" data-m="<?= $M ?>" data-y="<?= $Y ?>"></div>
<div class="row">
    <span style="font-size: larger; font-weight: bold">На <?= $D ?> число</span>
</div>

<?php if (isset($errors) && isset($errors['del-day'])): ?>
    <div class="row">
        <span style="font-size: larger; font-weight: bold; color: #c12e2a"><?= $errors['del-day'] ?></span>
    </div>
<?php endif; ?>
<?php foreach ($day_tours as $costCalendar): ?>
    <div class="row">
        <span style="font-size: larger"><i class="far fa-clock"></i><?= $costCalendar->time_at ?>
            <a href="#" class="del-day" data-id="<?= $costCalendar->id ?>"><i class="far fa-trash-alt"></i></a>
        </span>
    </div>
    <div class="row">
        &nbsp;&nbsp;&nbsp;<?= $costCalendar->tickets ?> билетов. Цена: <?= $costCalendar->cost->adult ?>
        /<?= $costCalendar->cost->child ?? '--' ?>/<?= $costCalendar->cost->preference ?? '--' ?>
    </div>
<?php endforeach; ?>
<?php if ($day_tours != null): ?>
    <div class="row pt-3">
        <label class="container">Скопировать по дням недели</label>
    </div>
    <div class="row">
        <div class="col-sm-3">
            С выбранной даты по:&nbsp;&nbsp;
        </div>
        <div class="col-sm-3">
            <input type="date" id="end-day" value="" class="form-control">
        </div>
    </div>
    <div class="row pt-3">
        <div class="col">
            <label class="container pl-1" style="display: contents;">
                <input type="checkbox" id="data-week-1"><span>&nbsp;Пн</span>
            </label>
            <label class="container pl-1" style="display: contents;">
                <input type="checkbox" id="data-week-2"><span>&nbsp;Вт</span>
            </label>
            <label class="container pl-1" style="display: contents;">
                <input type="checkbox" id="data-week-3"><span>&nbsp;Ср</span>
            </label>
            <label class="container pl-1" style="display: contents;">
                <input type="checkbox" id="data-week-4"><span>&nbsp;Чт</span>
            </label>
            <label class="container pl-1" style="display: contents;">
                <input type="checkbox" id="data-week-5"><span>&nbsp;Пт</span>
            </label>
            <label class="container pl-1" style="display: contents;">
                <input type="checkbox" id="data-week-6"><span>&nbsp;Сб</span>
            </label>
            <label class="container pl-1" style="display: contents;">
                <input type="checkbox" id="data-week-7"><span>&nbsp;Вс</span>
            </label>
        </div>
    </div>
    <div class="row pt-3">
        <input type="button" id="data-week-copy" value="Заполнить" class="form-control">
    </div>
<?php else: ?>
    <div class="row">
        <span style="font-size: larger; font-weight: bold">туры не заданы</span>
    </div>
<?php endif; ?>

