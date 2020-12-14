<?php

?>
<div class="row pt-3">
    <div class="col-sm-3">
    <label class="container">
        Скопировать по дням недели
    </label>
    С выбранной даты по:&nbsp;&nbsp; <input type="date" id="end-day" value="" class="form-control" style="display: inline !important; width: auto !important;">
    </div>
    <?= ''//date('Y-m-d', time())  ?>
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
    <div class="col-sm-3">
    <input type="button" id="fun-data-week-copy" value="Заполнить" class="form-control">
    </div>
</div>
