<?php

use booking\entities\booking\BookingItemInterface;
use booking\entities\Lang;
use booking\entities\user\User;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;

/* @var $booking BookingItemInterface */

$user = User::findOne($booking->getUserId());
$url = \Yii::$app->params['frontendHostInfo'];

$confirmation = $booking->getCheckBooking() == BookingHelper::BOOKING_CONFIRMATION;
$lang = $user->preferences->lang;
?>

<div class="mail-notice" style="color: #0b0b0b;">
    <table style="width: 100%; border: 0;color: #0b0b0b;">
        <tr>
            <td style="width: 25%"></td>
            <td style="text-align: right; width: 50%">
                <?= Lang::t('Номер брони', $lang) ?>:&#160;
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url . $booking->getLinks()['frontend'] ?>">
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
                <h2><?= Lang::t('Добрый день', $lang) . ', ' ?><span style="color: #062b31"><?= $user->personal->fullname->getFullname() ?></span>!</h2>
            </td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 50%; text-align: justify; border: 0; font-size: 16px;">
                <?= Lang::t('Вы забронировали', $lang) ?>
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url . $booking->getLinks()['entities'] ?>">
                    <?= $booking->getName() ?>
                </a>
                <?= Lang::t('на дату', $lang) ?> <b><?= date('d-m-Y', $booking->getDate()) . ' ' . BookingHelper::fieldAddToString($booking) ?></b>.<br>
                <?= Lang::t('Сумма к оплате', $lang) ?>: <b><?= CurrencyHelper::get(BookingHelper::merchant($booking)) ?></b><br>
                <?= $confirmation ? Lang::t('Необходимо подтвердить бронирование в течение суток. В противном случае, Ваше бронирование будет отменено автоматически', $lang). '.' : Lang::t('Оплату необходимо произвести в течение суток. В противном случае, Ваше бронирование будет отменено автоматически'). '.' ?>
            </td>
            <td style="width: 25%"></td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="font-size: 12px; width: 50%;">
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url . $booking->getLinks()['frontend'] ?>">
                    <?= $confirmation ? Lang::t('Подтвердить бронирование Вы можете в личном кабинете', $lang) : Lang::t('Оплатить бронирование Вы можете в личном кабинете', $lang) ?>
                </a>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>
