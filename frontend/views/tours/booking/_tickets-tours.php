<?php

/* @var $current CostCalendar */

use booking\entities\booking\tours\CostCalendar;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;

?>

<div class="col-12">
    <input type="hidden" value="" />
    <label for="booking-tour-time"><b><?= Lang::t('Укажите кол-во билетов') ?>:</b></label>
    <table>
    <?php if ($current->cost->adult): ?>
    <tr>
        <td width="70%"><?= Lang::t('Взрослый') . '(' . CurrencyHelper::get($current->cost->adult)?>): </td>
        <td>
            <input class="count-tickets form-control" id="count-adult" name="count-adult" type="number" min="0" value="0" max="<?= $current->tickets?>"/>
        </td>
    </tr>
    <?php endif; ?>
        <?php if ($current->cost->child): ?>
            <tr>
                <td><?= Lang::t('Детский') . '(' . CurrencyHelper::get($current->cost->child)?>): </td>
                <td>
                    <input class="count-tickets form-control" id="count-child" name="count-child" type="number" min="0" value="0" max="<?= $current->tickets?>"/>
                </td>
            </tr>
        <?php endif; ?>
        <?php if ($current->cost->preference): ?>
            <tr>
                <td><?= Lang::t('Льготный') . '(' . CurrencyHelper::get($current->cost->preference)?>): </td>
                <td>
                    <input class="count-tickets form-control" id="count-preference" name="count-preference" type="number" min="0" value="0" max="<?= $current->tickets?>"/>
                </td>
            </tr>
        <?php endif; ?>
    </table>

    <label id="label-count-tickets" data-count="<?= $current->getFreeTickets()?>"><?= Lang::t('Осталось билетов') . ':' . $current->getFreeTickets()?></label>
    <p><b><?= Lang::t('Промо-код') . ':' ?></b></p>
    <input class="form-control" id="discount" name="discount" type="text" value=""/>
</div>