<?php

use booking\entities\booking\cars\CostCalendar;

/* @var $costCalendar CostCalendar */
/* @var $D integer */
/* @var $M integer */
/* @var $Y integer */
/* @var $clear bool */
/* @var $errors array */
?>
<div id="data-day" data-d="<?= $D ?>" data-m="<?= $M ?>" data-y="<?= $Y ?>"></div>
<div class="card card-info">
    <div class="card-header">
        <span style="font-size: larger; font-weight: bold">На <?= $D ?> число</span>
    </div>
    <div class="card-body m-0 p-1">

        <?php if (isset($errors) && isset($errors['del-day'])): ?>
            <div class="row">
                <span style="font-size: larger; font-weight: bold; color: #c12e2a"><?= $errors['del-day'] ?></span>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-5">
                <div class="form-group">
                    <label>Кол-во авто</label>
                    <input class="form-control" id="_count" type="number" min="1"
                           max="<?= $car->quantity ?>"
                           value="<?= $costCalendar ? $costCalendar->count : $car->quantity ?>" width="100px" required>
                </div>
            </div>

            <div class="col-7">
                <div class="form-group">
                    <label>Прокат в руб/сут</label>
                    <input class="form-control" id="_cost" type="number"
                           value="<?= $costCalendar ? $costCalendar->cost : $car->cost ?>" min="0"
                           step="50" width="100px" required>
                </div>
            </div>
        </div>

        <div class="row pt-3">
            <div class="col">
                <a href="#" class="btn btn-success" id="send-new-car">Сохранить</a>
                <?php if ($clear): ?>
                    <a href="#" class="btn btn-warning" id="car-del-day" data-id="<?= $costCalendar->id ?>">Очистить
                        день</a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>