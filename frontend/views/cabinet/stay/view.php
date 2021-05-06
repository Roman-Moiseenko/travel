<?php

use booking\entities\booking\stays\BookingStay;
use booking\entities\user\User;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\cabinet\CheckBookingWidget;
use frontend\widgets\design\BtnCancel;
use frontend\widgets\design\BtnGeo;
use frontend\widgets\design\BtnPay;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $booking BookingStay */
/* @var $user User */


$this->title = $booking->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Мои бронирования'), 'url' => Url::to(['cabinet/booking/index'])];;
$this->params['breadcrumbs'][] = $this->title;

MagnificPopupAsset::register($this);
MapAsset::register($this);
$stay = $booking->stay;
?>
    <!-- Фото + Название + Ссылка -->
    <div class="d-flex p-2">
        <div>
            <ul class="thumbnails">
                <li>
                    <a class="thumbnail"
                       href="<?= $stay->mainPhoto->getThumbFileUrl('file', 'catalog_origin'); ?>">
                        <img src="<?= $stay->mainPhoto->getThumbFileUrl('file', 'cabinet_list'); ?>"
                             alt="<?= Html::encode($stay->getName()); ?>"/></a>
                </li>
            </ul>
        </div>
        <div class="flex-grow-1 align-self-center caption-list pl-3">
            <a href="<?= $booking->getLinks()->entities; ?>"><?= $stay->getName() ?></a>

        </div>
        <?php if ($booking->isNew() || $booking->isPay() || $booking->isConfirmation()): ?>
            <div class="ml-auto align-self-center  caption-list pl-3">
                <a href="<?= Url::to(['/cabinet/dialog/dialog', 'id' => BookingHelper::number($booking)]) ?>"><i
                            class="fas fa-shipping-fast"
                            title="<?= Lang::t('Задать вопросы по бронированию') ?>"></i></a>
            </div>
        <?php endif ?>
    </div>
    <!-- Блок от статуса -->
    <div class="booking-view">
        <!-- Общая информация -->
        <div class="card py-2 shadow-sm my-2" style="font-size: 14px;">
            <div class="card-body">
                <?= BookingHelper::stamp($booking) ?>
                <table class="adaptive-width-70">
                    <tbody>
                    <tr>
                        <th><?= Lang::t('Номер брони') ?>:</th>
                        <td colspan="3"><?= BookingHelper::number($booking) ?></td>
                    </tr>
                    <?php if ($booking->isPay()): ?>
                        <tr>
                            <th><?= Lang::t('ПИН-код') ?>:</th>
                            <td colspan="3"><?= $booking->getPinCode() ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <th><?= Lang::t('Дата заселения') ?>:</th>
                        <td colspan="3"><?= date('d-m-Y', $booking->getDate()) ?></td>
                    </tr>
                    <tr>
                        <th><?= Lang::t('Дата отъезда') ?>:</th>
                        <td colspan="3"><?= $booking->getAdd() ?></td>
                    </tr>
                    <tr>
                        <th><?= Lang::t('Гости') ?>:</th>
                        <td colspan="3"><?= $booking->guest ?></td>
                    </tr>
                    <?php if (count($booking->services) > 0): ?>
                        <tr>
                            <th>Дополнительные услуги:</th>
                            <td colspan="3"></td>
                        </tr>
                        <?php foreach ($booking->services as $service): ?>
                            <tr>
                                <th></th>
                                <td colspan="3"><?= $service->name ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <tr></tr>
                    <tr class="price-view py-2 my-2">
                        <th class="py-3 my-2"><?= Lang::t('Стоимость проживания') ?></th>
                        <td></td>
                        <td></td>
                        <td style="font-size: 22px; color: #333;"><span
                                    class=""><?= CurrencyHelper::get($booking->getPayment()->getFull()) ?> </span></td>
                    </tr>
                    <tr class="price-view py-2 my-2">
                        <th class="py-3 my-2"><?= Lang::t('Предоплата') . ' (' . $booking->getPayment()->percent . '%)' ?></th>
                        <td></td>
                        <td></td>
                        <td style="font-size: 22px; color: #333;"><?= CurrencyHelper::stat($booking->getPayment()->getPrepay()) ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php if ($booking->isNew()): ?>
                    <div class="d-flex pay-tour py-3">
                        <div>
                            <?= BtnCancel::widget([
                                'url' => Url::to(['/cabinet/stay/delete', 'id' => $booking->id]),
                            ]) ?>
                        </div>
                        <div class="ml-auto">
                            <?= BtnPay::widget([
                                'url' =>  Url::to(['/cabinet/pay/stay', 'id' => $booking->id]),
                                'paid_locality' => $booking->isPaidLocally(),
                            ])?>
                        </div>
                    </div>
                    <div style="font-size: 12px">
                        <?= Lang::t('* При предоплате, оставшаяся часть оплачивается на месте') ?><br>
                        <?php if ($booking->isPaidLocally()): ?>
                            <?= Lang::t('* Подтверждение бронирования - бесплатно. Оплачивайте проживание на месте.') ?>
                        <?php else: ?>
                            <?= Lang::t('* Перед оплатой бронирования, ознакомьтесь с нашей') . ' ' . Html::a(Lang::t('Политикой возврата'), Url::to(['/refund'])) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Чеки и бронь -->
        <?= CheckBookingWidget::widget([
            'action' => 'stay',
            'user' => $user,
            'booking' => $booking,
        ]) ?>
    </div>
    <!-- Информация о жилье -->
    <div class="card shadow-sm my-2">
        <div class="card-body">
            <!-- Описание -->

            <!-- Координаты -->
            <div class="row pt-4">
                <div class="col">
                <span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
                      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
                    <div class="container-hr">
                        <hr/>
                        <div class="text-left-hr"><?= Lang::t('Координаты') ?></div>
                    </div>
                    <div class="params-item-map">
                        <div class="row pb-2">
                            <div class="col-4">
                                <?= BtnGeo::widget([
                                    'caption' => 'Адрес',
                                    'target_id' => 'collapse-map',
                                ]) ?>
                            </div>
                            <div class="col-8"><?= $stay->address->address ?? ' ' ?></div>
                        </div>
                        <div class="collapse" id="collapse-map">
                            <div class="card card-body card-map">
                                <div class="row">
                                    <div class="col-8">
                                        <input id="bookingaddressform-address" class="form-control" width="100%"
                                               value="<?= $stay->address->address ?? ' ' ?>" type="hidden">
                                    </div>
                                    <div class="col-2">
                                        <input id="bookingaddressform-latitude" class="form-control" width="100%"
                                               value="<?= $stay->address->latitude ?? '' ?>" type="hidden">
                                    </div>
                                    <div class="col-2">
                                        <input id="bookingaddressform-longitude" class="form-control" width="100%"
                                               value="<?= $stay->address->longitude ?? '' ?>"
                                               type="hidden">
                                    </div>
                                </div>

                                <div class="row">
                                    <div id="map-view" style="width: 100%; height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $js = <<<EOD
    $(document).ready(function() {
        $('.thumbnails').magnificPopup({
            type:'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
    });
EOD;
$this->registerJs($js); ?>