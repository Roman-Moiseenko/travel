<?php

/* @var $current CostCalendar */

use booking\entities\booking\funs\CostCalendar;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;

?>
<input type="hidden" id="calendar-id" name="calendar-id[0]" value="<?= $current->id ?>"/>

<label for="booking-fun-time"><b><?= Lang::t('Укажите кол-во билетов') ?>:</b></label>
<table>
    <?php if ($current->cost->adult): ?>
        <tr>
            <td width="70%"><?= Lang::t('Взрослый') . '(' . CurrencyHelper::get($current->cost->adult) ?>):</td>
            <td>
                <input class="count-tickets-fun form-control" id="count-adult" name="count-adult" type="number" min="0"
                       value="0" max="<?= $current->tickets ?>"/>
            </td>
        </tr>
    <?php endif; ?>
    <?php if ($current->cost->child): ?>
        <tr>
            <td><?= Lang::t('Детский') . '(' . CurrencyHelper::get($current->cost->child) ?>):</td>
            <td>
                <input class="count-tickets-fun form-control" id="count-child" name="count-child" type="number" min="0"
                       value="0" max="<?= $current->tickets ?>"/>
            </td>
        </tr>
    <?php endif; ?>
    <?php if ($current->cost->preference): ?>
        <tr>
            <td><?= Lang::t('Льготный') . '(' . CurrencyHelper::get($current->cost->preference) ?>):</td>
            <td>
                <input class="count-tickets-fun form-control" id="count-preference" name="count-preference"
                       type="number" min="0" value="0" max="<?= $current->tickets ?>"/>
            </td>
        </tr>
    <?php endif; ?>
</table>

<label id="label-count-tickets"
       data-count="<?= $current->free() ?>"><?= Lang::t('Осталось билетов') . ': ' . $current->free() ?></label>
<?php if (!empty($current->fun->params->annotation)): ?>
<div>
    <label for="comment"><b><?= $current->fun->params->annotation ?>:</b></label>
    <textarea id="comment" name="comment" class="form-control" rows="2"></textarea>
</div>
<?php endif; ?>

<p><b><?= Lang::t('Промо-код') . ':' ?></b></p>
<input class="form-control" id="discount" name="discount" type="text" value=""/>
<!-- ИТОГО -->
<div class="row pt-4 pb-2">
    <div class="col-5 pr-1">
        <span style="font-size: 14px; font-weight: 600;">ИТОГО:</span>
    </div>
    <div class="col-4 px-1" id="fun-amount" data-amount="<?= 0 ?>">
        <span class="badge badge-success" style="font-size: 18px; font-weight: 600;">
            <?= ' - ' ?>
        </span>
    </div>
</div>