<?php

use booking\entities\booking\stays\CostCalendar;
use booking\entities\booking\stays\Stay;

/* @var $costCalendar CostCalendar */
/* @var $D integer */
/* @var $M integer */
/* @var $Y integer */
/* @var $clear bool */
/* @var $errors array */
/* @var $stay Stay */
?>
<div id="data-day" data-d="<?= $D ?>" data-m="<?= $M ?>" data-y="<?= $Y ?>"></div>
<div class="card card-info" style="max-width: 400px">
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
            <div class="col-12">
                <div class="form-group">
                    <label>Базовая цена за 1 ночь</label>
                    <input class="form-control" id="cost-base" type="number" min="1"
                           value="<?= $costCalendar ? $costCalendar->cost_base : $stay->cost_base ?>" width="100px" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Кол-во гостей в базовой цене</label>
                    <input class="form-control" id="guest-base" type="number" min="0" max="<?= $stay->params->guest ?>"
                           value="<?= $costCalendar ? $costCalendar->guest_base : $stay->guest_base ?>" width="100px"
                           step="1" width="100px">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Цена дополнительного места</label>
                    <input class="form-control" id="cost-add" type="number"
                           value="<?= $costCalendar ? $costCalendar->cost_add : $stay->cost_add ?>" min="0"
                           step="50" width="100px" required>
                </div>
            </div>
        </div>

        <div class="row pt-3">
            <div class="col">
                <a href="#" class="btn btn-success" id="send-new-stay">Сохранить</a>
                <?php if ($clear): ?>
                    <a href="#" class="btn btn-warning" id="stay-del-day" data-id="<?= $costCalendar->id ?>">Очистить
                        день</a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>