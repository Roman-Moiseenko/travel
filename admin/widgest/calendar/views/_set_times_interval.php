<?php

use booking\entities\booking\funs\CostCalendar;
use booking\entities\booking\funs\Fun;
use booking\helpers\funs\FunHelper;

/* @var $day_funs array */
/* @var $D integer */
/* @var $M integer */
/* @var $Y integer */
/* @var $clear bool */
?>
<div id="data-day" data-d="<?= $D ?>" data-m="<?= $M ?>" data-y="<?= $Y ?>"
     data-count-times="<?= count($day_funs) ?>"></div>
<div class="card card-info" style="max-width: 400px">
    <div class="card-header">
        <span style="font-size: larger; font-weight: bold">На <?= $D ?> число</span>
    </div>
    <div class="card-body m-0 p-1">
        <table>
            <thead>
            <tr>
                <th width="20px"></th>
                <th>Время</th>
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
            <?php foreach ($day_funs as $i => $time): ?>
                <tr>
                    <td>
                        <input type="checkbox" class="form-control form-control-sm checkbox-time"
                               id="checkbox-<?= $i ?>"
                               data-i="<?= $i ?>" <?= $time['check'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <span class="badge badge-success" style="font-size: 16px"><?= $time['begin'] ?></span>
                        - <span class="badge badge-success" style="font-size: 16px"><?= $time['end'] ?></span>
                        <input type="hidden" id="begin-<?= $i ?>" value="<?= $time['begin'] ?>">
                        <input type="hidden" id="end-<?= $i ?>" value="<?= $time['end'] ?>">

                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm" min="1" max="<?= $time['quantity'] ?>"
                               value="<?= $time['quantity'] ?>" id="quantity-<?= $i ?>">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm" min="0"
                               value="<?= $time['cost_adult'] ?>"
                               id="cost-adult-<?= $i ?>">
                    </td>
                    <td>
                        <?php if ($time['cost_child'] != null): ?>
                            <input type="number" class="form-control form-control-sm" min="0"
                                   value="<?= $time['cost_child'] ?>"
                                   id="cost-child-<?= $i ?>">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($time['cost_preference'] != null): ?>
                            <input type="number" class="form-control form-control-sm" min="0"
                                   value="<?= $time['cost_preference'] ?>"
                                   id="cost-preference-<?= $i ?>">
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
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
