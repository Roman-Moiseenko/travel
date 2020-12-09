<?php

/* @var $times array */
?>

<div class="row">
    <div class="col-sm-3">
        <b>Начало </b>
        <input name="TimesForm[0][begin]" class="form-control" width="100%" value="<?= empty($times) ? '' : $times[0]['begin'] ?>"
               type="time" id="begin-0">
    </div>
    <div class="col-sm-3">
        <b>Окончание </b>
        <input name="TimesForm[0][end]" class="form-control" width="100%" value="<?= empty($times) ? '' : $times[0]['end'] ?>"
               type="time" id="end-0">
    </div>
    <div class="col-sm-3">
        <b>Шаг </b>
        <input name="TimesForm[1][begin]" class="form-control" width="100%" value="<?= empty($times) ? '' : $times[1]['begin'] ?>"
               type="time" id="begin-0">
    </div>
</div>