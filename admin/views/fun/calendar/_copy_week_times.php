<?php

?>
<div class="card card-gray">
    <div class="card-header">Дублирование текущего дня</div>
    <div class="card-body m-0 p-1">
        <div class="row">
            <div class="col">
                <label class="container" for="end-day">Заполнить до:</label>
                <input type="date" id="end-day" value="" class="form-control" style="width: auto !important;">
            </div>
        </div>
        <div class="row">
            <label class="container">по дням недели:</label>
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
        <div class="row p-2">
            <div class="">
                <input type="button" id="fun-data-week-copy" value="Заполнить" class="form-control btn-info">
            </div>
        </div>
    </div>
</div>