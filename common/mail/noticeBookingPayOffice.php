<?php

use booking\entities\booking\BookingItemInterface;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;

/* @var $booking BookingItemInterface */

?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td></td>
            <td>
                <h2><?= 'Оплата услуги на сайте' ?><span style="color: #062b31"><?= $booking->getLegal()->name ?></span>!</h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= $booking->getAdmin()->username ?><br>
                <?= $booking->getName() ?><br>
                <?= 'на дату' ?> <b><?= date('d-m-Y', $booking->getDate()) . ' ' . BookingHelper::fieldAddToString($booking) ?></b>.<br>
                <?= 'Номер брони' ?>:&#160;<b><?= BookingHelper::number($booking) ?></b><br>
                <?= 'Сумма: ' ?>:&#160;<b><?= CurrencyHelper::get($booking->getAmountPayAdmin()) ?></b><br>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>
