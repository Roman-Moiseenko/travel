<?php

use booking\entities\booking\cars\CostCalendar;

/* @var $costCalendar CostCalendar */
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
<?php if($costCalendar): ?>
    <div class="row">

    </div>
    <div class="row">
        &nbsp;&nbsp;<?= $costCalendar->count ?> авто. Цена: <?= $costCalendar->cost ?>
        &nbsp;&nbsp;<a href="#" class="car-del-day" data-id="<?= $costCalendar->id ?>"><i class="far fa-trash-alt"></i></a>
    </div>
<?php endif; ?>
<?php if ($costCalendar != null): ?>
    <!--div class="row">
        <label class="container">
            <input type="checkbox" id="car-data-day-copy"><span>&nbsp;Копировать на другие дни</span>
        </label>
        <i>Поставьте флажок, и выбирайте дни. После снимите флажок и выберите любой день</i>
    </div-->
    <div class="row pt-3">

            <label class="container">
                Скопировать по дням недели
            </label>
            С выбранной даты по:&nbsp;&nbsp; <input type="date" id="end-day" value="">
        <?= ''//date('Y-m-d', time()) ?>
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
        <input type="button" id="car-data-week-copy" value="Заполнить">
    </div>
<?php else: ?>
    <div class="row">
        <span style="font-size: larger; font-weight: bold"> календарь не установлен</span>
        <div class="new-cars pt-2">
        </div>
    </div>

<?php endif; ?>

