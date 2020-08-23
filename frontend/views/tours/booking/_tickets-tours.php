<?php

/* @var $current CostCalendar */

use booking\entities\booking\tours\CostCalendar;
use booking\helpers\CurrencyHelper;

?>

<div class="col-12">
    <input type="hidden" value="" />
    <label for="booking-tour-time">Укажите кол-во билетов:</label>
    <table>
    <?php if ($current->cost->adult): ?>
    <tr>
        <td width="70%">Взрослый (<?= CurrencyHelper::get($current->cost->adult)?>): </td>
        <td>
            <input class="count-tickets form-control" id="count-adult" name="count-adult" type="number" min="0" value="0" max="<?= $current->tickets?>"/>
        </td>
    </tr>
    <?php endif; ?>
        <?php if ($current->cost->child): ?>
            <tr>
                <td>Детский (<?= CurrencyHelper::get($current->cost->child)?>): </td>
                <td>
                    <input class="count-tickets form-control" id="count-child" name="count-child" type="number" min="0" value="0" max="<?= $current->tickets?>"/>
                </td>
            </tr>
        <?php endif; ?>
        <?php if ($current->cost->preference): ?>
            <tr>
                <td>Льготный (<?= CurrencyHelper::get($current->cost->preference)?>): </td>
                <td>
                    <input class="count-tickets form-control" id="count-preference" name="count-preference" type="number" min="0" value="0" max="<?= $current->tickets?>"/>
                </td>
            </tr>
        <?php endif; ?>
    </table>
    <label id="label-count-tickets" data-count="<?= $current->getFreeTickets()?>">Осталось билетов: <?= $current->getFreeTickets()?></label>
</div>