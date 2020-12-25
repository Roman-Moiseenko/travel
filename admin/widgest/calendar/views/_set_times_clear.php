<?php

use booking\entities\booking\funs\CostCalendar;
use booking\entities\booking\funs\Fun;

/* @var $day_funs array */
/* @var $D integer */
/* @var $M integer */
/* @var $Y integer */
/* @var $quantity int */
/* @var $clear bool */
?>
<div id="data-day" data-d="<?= $D ?>" data-m="<?= $M ?>" data-y="<?= $Y ?>"
     data-count-times="<?= 0 ?>"></div>
<div class="card card-info" style="max-width: 400px">
    <div class="card-header">
        <span style="font-size: larger; font-weight: bold">На <?= $D ?> число</span>
    </div>
    <div class="card-body m-0 p-1">
        <table>
            <thead>
            <tr>
                <th width="80px">Кол-во</th>
                <th>Взрослый</th>
                <?php if ($day_funs[0]['cost_child'] != null): ?>
                    <th>Детский</th>
                <?php endif; ?>
                <?php if ($day_funs[0]['cost_preference'] != null): ?>
                    <th>Льготный</th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input type="number" class="form-control form-control-sm" min="1" max="<?= $quantity ?>"
                           value="<?= $day_funs[0]['quantity'] ?>" id="quantity">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" min="0"
                           value="<?= $day_funs[0]['cost_adult'] ?>"
                           id="cost-adult">
                </td>
                <td>
                    <?php if ($day_funs[0]['cost_child'] != null): ?>
                        <input type="number" class="form-control form-control-sm" min="0"
                               value="<?= $day_funs[0]['cost_child'] ?>"
                               id="cost-child">
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($day_funs[0]['cost_preference'] != null): ?>
                        <input type="number" class="form-control form-control-sm" min="0"
                               value="<?= $day_funs[0]['cost_preference'] ?>"
                               id="cost-preference">
                    <?php endif; ?>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="row pt-3">
            <div class="col">
                <a href="#" class="btn btn-success" id="send-new-fun">Сохранить</a>
                <?php if ($clear): ?>
                    <a href="#" class="btn btn-warning" id="send-del-fun">Очистить день</a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>