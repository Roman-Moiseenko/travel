<?php

use booking\entities\admin\Contact;
use booking\entities\booking\cars\BookingCar;
use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\scr;
use booking\helpers\tours\AddressHelper;
use frontend\assets\MapAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $booking BookingCar */

$pt = '';
$count = count($booking->car->address);
foreach ($booking->car->address as $i => $address) {
    $pt .= $address->longitude . ',' . $address->latitude . ',pmwtm' . ($i + 1);
    if ($i + 1 !== $count) $pt .= '~';
}
$latitude = $booking->car->address[0]->latitude;
$longitude = $booking->car->address[0]->longitude;
$legal = $booking->getLegal();
?>

<div class="container">
    <div class="row">
        <div style="text-align: center">
            <h2><?= Lang::t('Подтверждение бронирования') ?></h2>
        </div>
        <img src="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/logo-pdf.png' ?>"
             style="height: 50px; width: auto;">
        <div style="border: 2px solid black; border-radius: 10px; margin: 4px">
            <table width="100%" style="border: 0;border-collapse: collapse;">
                <tbody>
                <tr>
                    <td width="30%" style=""><b><?= Lang::t('Номер брони') ?>:</b>
                    </td>
                    <td width="70%"><?= BookingHelper::number($booking) ?></td>
                </tr>
                <tr style="background-color: #e4e4e4">
                    <th><?= Lang::t('ПИН-код') ?>:</th>
                    <td><?= $booking->getPinCode() ?></td>
                </tr>
                <tr>
                    <td><b><?= Lang::t('Авто') ?>:</b></td>
                    <td><?= $booking->car->getName() ?></td>
                </tr>
                <tr style="background-color: #e4e4e4">
                    <td><b><?= Lang::t('Дата') ?>:</b></td>
                    <td><?= date('d-m-Y', $booking->getDate()) ?></td>
                </tr>
                <tr>
                    <td><b><?= Lang::t(' по') ?>:</b></td>
                    <td><?= $booking->getAdd() ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="border: 2px solid black; border-radius: 10px; margin: 4px">
            <table width="100%" style="border: 0;border-collapse: collapse;">
                <tbody>
                    <tr style="background-color: #e4e4e4">
                        <td><b><?= Lang::t('Кол-во') ?>:</b></td>
                        <td><?= $booking->count ?></td>
                    </tr>
                <tr>
                    <td><b><?= Lang::t('Оплачено') ?>:</b></td>
                    <td><?= CurrencyHelper::cost($booking->getAmountDiscount()) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="height: 300px; border: 2px solid black; border-radius: 10px; margin: 4px">
            <div style="margin-left: 10px; margin-bottom: 30px; margin-top: 12px">
                <img src="https://static-maps.yandex.ru/1.x/?ll=<?= $longitude ?>,<?= $latitude ?>&size=650,250&z=9&l=map&lang=<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>&pt=<?= $pt ?>">
            </div>
            <b><?= Lang::t('Точки пункта проката') ?>:</b>
            <table width="100%" style="border: 0;border-collapse: collapse;">
                <tbody>
                <?php foreach ($booking->car->address as $i => $address): ?>
                <tr>
                    <td width="10px" style=""><?= ($i + 1) ?>.
                    </td>
                    <td width="70%"><?= AddressHelper::short($address->address) ?> <span id="address"></span></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div>
            <br>
            <?= Lang::t('По любым вопросам, связанным с прокатом данного транспортного средства, Вы всегда можете связаться с провайдером услуг следующим способом') ?>
            :<br>
            <table class="table">
                <tbody>
                <?php foreach ($legal->contactAssignment as $contact): ?>
                    <tr>
                        <th width="20px"><img src="<?= $contact->contact->getThumbFileUrl('photo', 'list') ?>"/></th>
                        <th>
                            <?php if ($contact->contact->type == Contact::NO_LINK): ?>
                                <?= Html::encode($contact->value) ?>
                            <?php else: ?>
                                <a href="<?= $contact->contact->prefix . $contact->value ?>"><?= Html::encode($contact->value) ?></a>
                            <?php endif; ?>
                        </th>
                        <td><?= Html::encode($contact->description) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <hr/>
            <?= Lang::t('В случае возникновения технических проблем, которые не может решить провайдер, Вы всегда можете обратиться в службу поддержки с личного кабинета') ?>
            .
            <?= Lang::t('Либо связаться с нами по телефону') . ' ' . \Yii::$app->params['supportPhone'] ?>.
        </div>
    </div>
</div>