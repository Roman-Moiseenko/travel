<?php

use booking\entities\booking\BookingItemInterface;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;

/* @var $booking BookingItemInterface */

$user = $booking->getAdmin();
$url = \Yii::$app->params['adminHostInfo'];
?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%; border: 0;color: #0b0b0b;">
        <tr>
            <td style="width: 25%"></td>
            <td style="text-align: right; width: 50%">
                <?= 'Номер брони' ?>:&#160;
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url . $booking->getLinks()['booking'] ?>">
                    <b><?= BookingHelper::number($booking) ?></b>
                </a>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
    <table style="width: 100%;color: #0b0b0b;">
        <tr>
            <td></td>
            <td>
                <h2><?= 'Добрый день, ' ?><span style="color: #062b31"><?= $booking->getLegal()->name ?></span>!</h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= 'У Вас новое подтверждение.' ?>
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url . $booking->getLinks()['admin'] ?>">
                    <?= $booking->getName() ?>
                </a>
                <?= 'на дату' ?> <b><?= date('d-m-Y', $booking->getDate()) . ' ' . BookingHelper::fieldAddToString($booking) ?></b>.<br>
                <?= 'Сумма оплаты составила' ?>: <b><?= CurrencyHelper::get($booking->getAmountPayAdmin()) ?></b><br>
                <?= '' ?>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>
