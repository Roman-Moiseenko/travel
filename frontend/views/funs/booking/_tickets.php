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
<!-- ИТОГО -->
<div id="fun-amount"></div>