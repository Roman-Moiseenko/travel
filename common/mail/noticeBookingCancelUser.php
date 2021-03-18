<?php

use booking\entities\booking\BaseBooking;
use booking\entities\Lang;
use booking\entities\user\User;
use booking\helpers\BookingHelper;

/* @var $booking BaseBooking */

$user = User::findOne($booking->getUserId());
$url = \Yii::$app->params['frontendHostInfo'];

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
                <?= Lang::t('Было отменено Ваше бронирование', $lang) ?>
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url . $booking->getLinks()['entities'] ?>">
                    <?= $booking->getName() ?>
                </a>
                <?= ' ' . Lang::t('на дату', $lang) ?> <b><?= date('d-m-Y', $booking->getDate()) . ' ' . BookingHelper::fieldAddToString($booking) ?></b>.<br>
            </td>
            <td style="width: 25%"></td>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="font-size: 12px; width: 50%;">
                <?= Lang::t('В случае возникновения вопросов, пожалуйста, свяжитесь со', $lang) ?>
                <a style="text-decoration: none; color: #0071c2;" href="<?= $url . '/support' ?>">
                    <?= Lang::t('Службой поддержки', $lang) ?>
                </a>
            </td>
            <td style="width: 25%"></td>
        </tr>
    </table>
</div>
