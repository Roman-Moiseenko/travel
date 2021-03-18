<?php

use booking\entities\admin\Contact;
use booking\entities\booking\funs\BookingFun;
use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\tours\AddressHelper;
use frontend\assets\MapAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $booking BookingFun */
/*
 * $latitude = $booking->calendar->tour->params->beginAddress->latitude;
$longitude = $booking->calendar->tour->params->beginAddress->longitude;
$js = <<<JS
// Загрузка адреса по карте
ymaps.ready(init);
function init() {
    var coords = [$latitude, $longitude];
    ymaps.geocode(coords).then(function (res) {
        var firstGeoObject = res.geoObjects.get(0);
        $('#address').html(firstGeoObject.getAddressLine());
    });
}
JS;

$this->registerJs($js);
*/

$latitude = $booking->fun->address->latitude;
$longitude = $booking->fun->address->longitude;
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
                    <td><b><?= Lang::t('Тур') ?>:</b></td>
                    <td><?= $booking->getName() ?></td>
                </tr>
                <tr style="background-color: #e4e4e4">
                    <td><b><?= Lang::t('Дата') ?>:</b></td>
                    <td><?= date('d-m-Y', $booking->getDate()) ?></td>
                </tr>
                <tr>
                    <td><b><?= Lang::t('Время') ?>:</b></td>
                    <td><?= $booking->getAdd() ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="border: 2px solid black; border-radius: 10px; margin: 4px">
            <table width="100%" style="border: 0;border-collapse: collapse;">
                <tbody>
                <tr>
                    <td width="30%"
                        style="background-color: #e4e4e4"><b><?= Lang::t('Количество билетов') ?>:</b>
                    </td>
                </tr>
                <?php if ($booking->count->adult): ?>
                    <tr>
                        <td><b><?= Lang::t('Взрослый') ?>:</b></td>
                        <td><?= $booking->count->adult ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($booking->count->child): ?>
                    <tr>
                        <td><b><?= Lang::t('Детский') ?>:</b></td>
                        <td><?= $booking->count->child ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($booking->count->preference): ?>
                    <tr>
                        <td><b><?= Lang::t('Льготный') ?>:</b></td>
                        <td><?= $booking->count->preference ?></td>
                    </tr>
                <?php endif; ?>
                <tr style="background-color: #e4e4e4">
                    <td><b><?= Lang::t('Оплачено') ?>:</b></td>
                    <td><?= CurrencyHelper::cost($booking->getPayment()->getPrepay()) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="height: 300px; border: 2px solid black; border-radius: 10px; margin: 4px">
            <div style="margin-left: 10px; margin-bottom: 30px; margin-top: 12px">
                <img src="https://static-maps.yandex.ru/1.x/?ll=<?= $longitude ?>,<?= $latitude ?>&size=650,250&z=14&l=map&lang=<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>&pt=<?= $longitude ?>,<?= $latitude ?>,pmwtm1">
            </div>
            <table width="100%" style="border: 0;border-collapse: collapse;">
                <tbody>
                <tr>
                    <td width="30%" style=""><b><?= Lang::t('Место сбора') ?>:</b>
                    </td>
                    <td width="70%"><?= AddressHelper::short($booking->fun->address->address) ?> <span id="address"></span></td>
                </tr>
                <tr>
                    <td width="30%" style=""><b><?= Lang::t('Место окончания') ?>:</b>
                    </td>
                    <td width="70%"><?= AddressHelper::short($booking->fun->address->address) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div>
            <br>
            <?= Lang::t('По любым вопросам, связанным с проведением данного тура, Вы всегда можете связаться с провайдером услуг следующим способом') ?>
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