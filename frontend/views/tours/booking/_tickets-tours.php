<?php

/* @var $current CostCalendar */

use booking\entities\booking\tours\CostCalendar;
use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
$private = $current->tour->isPrivate();
$tour = $current->tour
?>
    <input type="hidden" value="" />
<?php if ($tour->isPrivate()): ?>
    <input id="count-adult" name="count-adult" type="hidden" value="1" />
    <?php if ($tour->extra_time_cost): ?>
    <table width="100%">
        <tr>
            <td><?= Lang::t('Дополнительное время') ?>:</td>
            <td>
                <select class="form-control services" id="time-count" name="time-count">
                    <?php for ($i = 0; $i <= $tour->extra_time_max; $i++):?>
                    <option value="<?= $i ?>"><?= $i . ' ' . Lang::t('ч') ?></option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php endif; ?>
    <?php if (count($tour->capacities)): ?>
        <table width="100%">
            <tr>
                <td><?= Lang::t('Количество гостей') ?>:</td>
                <td>
                    <select class="form-control services" id="capacity-id" name="capacity-id">
                        <option value=""><?= Lang::t('до') . ' ' . $tour->params->groupMax . ' ' . Lang::t('человек') ?></option>
                        <?php foreach ($tour->capacities as $capacity):?>
                            <option value="<?= $capacity->id ?>"><?= Lang::t('до') . ' ' . $capacity->count . ' ' . Lang::t('человек') ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
    <?php endif; ?>
    <?php if (count($tour->transfers)): ?>
        <table width="100%">
            <tr>
                <td><?= Lang::t('Трансфер') ?>:</td>
                <td>
                    <select class="form-control services" id="transfer-id" name="transfer-id">
                        <option value=""><?= Lang::t('Не требуется') ?></option>
                        <?php foreach ($tour->transfers as $transfer):?>
                            <option value="<?= $transfer->id ?>"><?= $transfer->from->getName() . '-' . $transfer->to->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
    <?php endif; ?>
<?php else: ?>
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
    <label id="label-count-tickets" data-count="<?= $current->free()?>"><?= Lang::t('Осталось билетов') . ': ' . $current->free()?></label>
<?php endif; ?>

<!-- ИТОГО -->
<div id="tour-amount"></div>
