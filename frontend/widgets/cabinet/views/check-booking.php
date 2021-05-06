<?php

use booking\entities\booking\BaseBooking;
use booking\entities\Lang;
use booking\entities\user\User;
use frontend\widgets\design\BtnCancel;
use frontend\widgets\design\smBtnPrint;
use yii\helpers\Url;

/* @var $booking BaseBooking */
/* @var $user User */
/* @var $action string */


$print_booking = '/cabinet/print/' . $action;
$print_check = '/cabinet/print/check'; //CONST
$cancel_booking_pay = '/cabinet/' . $action . '/cancelpay';
$cancel_booking = '/cabinet/' . $action . '/delete';
?>
<?php if ($booking->isPay()): ?>
    <div class="card shadow-sm py-2 my-2">
        <div class="card-body nowrap-parent">
            <span style="white-space: normal !important; color: #444;
            font-size: 27px;text-align: left !important;"><?= Lang::t('Ваше бронирование оплачено') ?>!</span>
            <ul class="reassurance__list">
                <li style="white-space: normal !important;">
                    <?= Lang::t('Подтверждение бронирования отправлено на ваш адрес') ?>
                    <b><?= $user->email ?></b>
                </li>
                <li>
                    <div class="nowrap-child">
                        <?= Lang::t('Распечатать подтверждение') ?>
                        <?= smBtnPrint::widget(['url' => Url::to([$print_booking, 'id' => $booking->id])]) ?>
                    </div>
                </li>
                <li>
                    <?= Lang::t('Распечатать чек об оплате') ?>
                    <?= smBtnPrint::widget(['url' => Url::to([$print_check, 'id' => $booking->id])]) ?>
                </li>
            </ul>
            <?php if ($booking->isCancellation()): ?>
                <div class="py-3">
                    <?= BtnCancel::widget(['url' => Url::to([$cancel_booking_pay, 'id' => $booking->id]), 'caption' => 'Отменить бронирование']) ?>
                </div>
                <label>* <?= Lang::t('В случае отмены платежа комиссия банка не возвращается') ?></label>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php if ($booking->isConfirmation()): ?>
    <div class="card shadow-sm py-2 my-2">
        <div class="card-body nowrap-parent">
            <span style="white-space: normal !important; color: #444;
            font-size: 27px;text-align: left !important;"><?= Lang::t('Ваше бронирование подтверждено') ?>!</span>
            <ul class="reassurance__list">
                <li style="white-space: normal !important;">
                    <?= Lang::t('Подтверждение бронирования отправлено на ваш адрес') ?>
                    <b><?= $user->email ?></b>
                </li>
                <li>
                    <div class="nowrap-child">
                        <?= Lang::t('Распечатать подтверждение') ?>
                        <?= smBtnPrint::widget(['url' => Url::to([$print_booking, 'id' => $booking->id])]) ?>
                    </div>
                </li>
            </ul>
            <?php if ($booking->getDate() > time()): ?>
            <div class="pt-4">
                    <?= BtnCancel::widget(['url' => Url::to([$cancel_booking, 'id' => $booking->id]), 'caption' => 'Отменить бронирование']) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
