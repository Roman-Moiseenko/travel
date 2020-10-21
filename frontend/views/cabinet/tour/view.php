<?php

use booking\entities\user\User;

/* @var $booking BookingTour */
/* @var $user User */

use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\ToursHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $booking->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Мои бронирования'), 'url' => Url::to(['cabinet/booking/index'])];;
$this->params['breadcrumbs'][] = $this->title;

MapAsset::register($this);
MagnificPopupAsset::register($this);
$tour = $booking->calendar->tour;
?>
    <!-- Фото + Название + Ссылка -->
    <div class="d-flex p-2">
        <div>
            <ul class="thumbnails">
                <li>
                    <a class="thumbnail"
                       href="<?= $tour->mainPhoto->getThumbFileUrl('file', 'catalog_origin'); ?>">
                        <img src="<?= $tour->mainPhoto->getThumbFileUrl('file', 'cabinet_list'); ?>"
                             alt="<?= Html::encode($tour->getName()); ?>"/></a>
                </li>
            </ul>
        </div>
        <div class="flex-grow-1 align-self-center caption-list pl-3">
            <a href="<?= $booking->getLinks()['entities']; ?>"><?= $tour->getName() ?></a>

        </div>
        <?php if ($booking->status == BookingHelper::BOOKING_STATUS_NEW || $booking->status == BookingHelper::BOOKING_STATUS_PAY):?>
        <div class="ml-auto align-self-center  caption-list pl-3">
            <a href="<?= Url::to(['/cabinet/dialog/dialog', 'id' => BookingHelper::number($booking)]) ?>"><i class="fas fa-shipping-fast" title="<?=Lang::t('Задать вопросы по бронированию')?>"></i></a>
        </div>
        <?php endif ?>
    </div>
    <!-- Блок от статуса -->
    <div class="booking-view">
        <!-- Общая информация -->
        <div class="card py-2 shadow-sm my-2" style="font-size: 14px;">
            <div class="card-body">
                <table width="70%">
                    <tbody>
                    <tr>
                        <th><?= Lang::t('Номер брони') ?>:</th>
                        <td><?= BookingHelper::number($booking) ?></td>
                    </tr>
                    <tr>
                        <th><?= Lang::t('ПИН-код') ?>:</th>
                        <td><?= $booking->getPinCode() ?></td>
                    </tr>
                    <tr>
                        <th><?= Lang::t('Дата тура')?>:</th>
                        <td><?= date('d-m-Y', $booking->calendar->tour_at) ?></td>
                        <td>
                            <?= BookingHelper::stamp($booking->status) ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= Lang::t('Время начало')?>:</th>
                        <td><?= $booking->calendar->time_at ?></td>
                    </tr>
                    <?php if ($booking->count->adult !== 0): ?>
                        <tr>
                            <th><?= Lang::t('Взрослый билет')?></th>
                            <td><?= CurrencyHelper::get($booking->calendar->cost->adult) ?></td>
                            <td>x <?= $booking->count->adult ?> шт</td>
                            <td><?= CurrencyHelper::get((int)$booking->count->adult * (int)$booking->calendar->cost->adult) ?> </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($booking->count->child !== 0): ?>
                        <tr>
                            <th><?= Lang::t('Детский билет') ?></th>
                            <td><?= CurrencyHelper::get($booking->calendar->cost->child) ?></td>
                            <td>x <?= $booking->count->child ?> <?= Lang::t('шт')?></td>
                            <td><?= CurrencyHelper::get((int)$booking->count->child * (int)$booking->calendar->cost->child) ?> </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($booking->count->preference !== 0): ?>
                        <tr>
                            <th><?= Lang::t('Льготный билет') ?></th>
                            <td><?= CurrencyHelper::get($booking->calendar->cost->preference) ?></td>
                            <td>x <?= $booking->count->preference ?> <?= Lang::t('шт') ?></td>
                            <td><?= CurrencyHelper::get((int)$booking->count->preference * (int)$booking->calendar->cost->preference) ?> </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($booking->discount != null): ?>
                    <tr class="py-2 my-2">
                        <th class="py-3 my-2"><?= Lang::t('Скидка') ?></th>
                        <td></td>
                        <td></td>
                        <td><?= CurrencyHelper::get($booking->bonus == 0 ? $booking->getAmount() * $booking->discount->percent/100 : $booking->bonus) . ' (' .  $booking->discount->promo . ')' ?> </td>
                    </tr>
                    <?php endif; ?>
                    <tr></tr>
                    <tr class="price-view py-2 my-2">
                        <th class="py-3 my-2"><?= Lang::t('Сумма платежа') ?></th>
                        <td></td>
                        <td></td>
                        <td><?= CurrencyHelper::get((int)$booking->getAmountPay()) ?> </td>
                    </tr>
                    </tbody>
                </table>
                <?php if ($booking->status == BookingHelper::BOOKING_STATUS_NEW): ?>
                    <div class="d-flex pay-tour py-3">
                        <div>
                            <a href="<?= Url::to(['/cabinet/tour/delete', 'id' => $booking->id]) ?>"
                               class="btn btn-default"><?= Lang::t('Отменить') ?></a>
                        </div>
                        <div class="ml-auto">
                            <a href="<?= Url::to(['/cabinet/pay/tour', 'id' => $booking->id]) ?>"
                               class="btn btn-primary"><?= Lang::t('Оплатить') ?></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Чеки и бронь -->
        <?php if ($booking->status == BookingHelper::BOOKING_STATUS_PAY): ?>
            <div class="card shadow-sm py-2 my-2">
                <div class="card-body nowrap-parent">
                    <h2><?= Lang::t('Ваше бронирование подтверждено')?>!</h2>
                    <ul class="reassurance__list">
                        <li>
                            <?= Lang::t('Подтверждение бронирования отправлено на ваш адрес') ?> <b><?= $user->email ?></b>
                        </li>
                        <li>
                            <div class="nowrap-child">
                                <?= Lang::t('Распечатать подтверждение')?>
                                <a class="btn-sm btn-primary "
                                   href="<?= Url::to(['/cabinet/print/tour', 'id' => $booking->id]) ?>">
                                    <i class="fas fa-print"></i></a>
                            </div>
                        </li>
                        <li>
                            <?= Lang::t('Распечатать чек об оплате')?>
                            <a class="btn-sm btn-primary"
                               href="<?= Url::to(['/cabinet/print/check', 'id' => $booking->id]) ?>">
                                <i class="fas fa-print"></i></a>
                        </li>
                    </ul>
                    <?php if ($booking->calendar->tour->isCancellation($booking->calendar->tour_at)): ?>
                        <a href="<?= Url::to(['/cabinet/tour/cancelpay', 'id' => $booking->id]) ?>"
                           class="btn btn-default"><?= Lang::t('Отменить')?> *</a><br>
                    <label>* <?= Lang::t('В случае отмены платежа, взымается комиссия банка, до 4%')?></label>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <!-- Информация от туре -->
    <div class="card shadow-sm my-2">
        <div class="card-body">
            <!-- Описание -->
            <div class="row">
                <div class="col params-tour">
                    <div class="container-hr">
                        <hr/>
                        <div class="text-left-hr"><?= Lang::t('Описание') ?></div>
                    </div>
                    <p class="text-justify">
                        <?= Yii::$app->formatter->asHtml($tour->getDescription(), [
                            'Attr.AllowedRel' => array('nofollow'),
                            'HTML.SafeObject' => true,
                            'Output.FlashCompat' => true,
                            'HTML.SafeIframe' => true,
                            'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                        ]) ?>
                    </p>
                </div>
            </div>
            <!-- Параметры -->
            <div class="row pt-4">
                <div class="col params-tour">
                    <div class="container-hr">
                        <hr/>
                        <div class="text-left-hr"><?= Lang::t('Параметры') ?></div>
                    </div>
                    <span class="params-item">
                    <i class="far fa-clock"></i>&#160;&#160;<?= $tour->params->duration ?>
                </span>
                    <span class="params-item">
                    <?php if ($tour->params->private) {
                        echo '<i class="fas fa-user"></i>&#160;&#160;' .  Lang::t('Индивидуальный');
                    } else {
                        echo '<i class="fas fa-users"></i>&#160;&#160; ' .  Lang::t('Групповой');
                    }
                    ?>
                </span>
                    <span class="params-item">
                    <i class="fas fa-user-friends"></i>&#160;&#160;<?= ToursHelper::group($tour->params->groupMin, $tour->params->groupMax) ?>
                </span>
                    <span class="params-item">
                    <i class="fas fa-user-clock"></i>&#160;&#160;<?= Lang::t('Ограничения по возрасту') . ' ' . ToursHelper::ageLimit($tour->params->agelimit) ?>
                </span>
                    <span class="params-item">
                    <i class="fas fa-ban"></i>&#160;&#160;<?= ToursHelper::cancellation($tour->cancellation) ?>
                </span>
                    <span class="params-item">
                    <i class="fas fa-layer-group"></i>&#160;&#160;
                                    <?php foreach ($tour->types as $type) {
                                        echo Lang::t($type->name) . ' | ';
                                    }
                                    echo Lang::t($tour->type->name); ?>
                </span>
                </div>
            </div>
            <!-- Дополнения -->
            <div class="row pt-4">
                <div class="col">
                    <div class="container-hr">
                        <hr/>
                        <div class="text-left-hr"><?= Lang::t('Дополнения') ?></div>
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                        <?php
                        foreach ($tour->extra as $extra): ?>
                            <?php if (!empty($extra->name)): ?>
                                <tr>
                                    <th><?= Html::encode($extra->getName()) ?></th>
                                    <td><?= Html::encode($extra->getDescription()) ?></td>
                                    <td><?= CurrencyHelper::get($extra->cost) ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Координаты -->
            <div class="row pt-4">
                <div class="col">
                    <div class="container-hr">
                        <hr/>
                        <div class="text-left-hr"><?= Lang::t('Координаты') ?></div>
                    </div>
                    <div class="params-item-map">
                        <div class="row">
                            <div class="col-4">
                                <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                                        data-target="#collapse-map"
                                        aria-expanded="false" aria-controls="collapse-map">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>&#160;<?= Lang::t('Место сбора') ?>:
                            </div>
                            <div class="col-8" id="address"></div>
                        </div>
                        <div class="collapse" id="collapse-map">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <input id="bookingaddressform-address" class="form-control" width="100%"
                                               value="<?= $tour->params->beginAddress->address ?? ' ' ?>" type="hidden">
                                    </div>
                                    <div class="col-2">
                                        <input id="bookingaddressform-latitude" class="form-control" width="100%"
                                               value="<?= $tour->params->beginAddress->latitude ?? '' ?>" type="hidden">
                                    </div>
                                    <div class="col-2">
                                        <input id="bookingaddressform-longitude" class="form-control" width="100%"
                                               value="<?= $tour->params->beginAddress->longitude ?? '' ?>"
                                               type="hidden">
                                    </div>
                                </div>

                                <div class="row">
                                    <div id="map-view" style="width: 100%; height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="params-item-map">
                        <div class="row">
                            <div class="col-4">

                                <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                                        data-target="#collapse-map-2"
                                        aria-expanded="false" aria-controls="collapse-map-2">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>&#160;<?= Lang::t('Место окончания') ?>:
                            </div>
                            <div class="col-8" id="address-2"></div>
                        </div>
                        <div class="collapse" id="collapse-map-2">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <input id="bookingaddressform-address-2" class="form-control" width="100%"
                                               value="<?= $tour->params->endAddress->address ?? ' ' ?>" type="hidden">
                                    </div>
                                    <div class="col-2">
                                        <input id="bookingaddressform-latitude-2" class="form-control" width="100%"
                                               value="<?= $tour->params->endAddress->latitude ?? '' ?>" type="hidden">
                                    </div>
                                    <div class="col-2">
                                        <input id="bookingaddressform-longitude-2" class="form-control" width="100%"
                                               value="<?= $tour->params->endAddress->longitude ?? '' ?>" type="hidden">
                                    </div>
                                </div>

                                <div class="row">
                                    <div id="map-view-2" style="width: 100%; height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="params-item-map">
                        <div class="row">
                            <div class="col-4">

                                <button class="btn btn-outline-secondary" type="button" data-toggle="collapse"
                                        data-target="#collapse-map-3"
                                        aria-expanded="false" aria-controls="collapse-map-2">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>&#160;<?= Lang::t('Место проведение') ?>:
                            </div>
                            <div class="col-8" id="address-3"></div>
                        </div>
                        <div class="collapse" id="collapse-map-3">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <input id="bookingaddressform-address-3" class="form-control" width="100%"
                                               value="<?= $tour->address->address ?? ' ' ?>" type="hidden">
                                    </div>
                                    <div class="col-2">
                                        <input id="bookingaddressform-latitude-3" class="form-control" width="100%"
                                               value="<?= $tour->address->latitude ?? '' ?>" type="hidden">
                                    </div>
                                    <div class="col-2">
                                        <input id="bookingaddressform-longitude-3" class="form-control" width="100%"
                                               value="<?= $tour->address->longitude ?? '' ?>" type="hidden">
                                    </div>
                                </div>

                                <div class="row">
                                    <div id="map-view-3" style="width: 100%; height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Информация от туре -->
    <div class="card py-2 shadow-sm my-2">
        <div class="card-body">
            <h2><?= Lang::t('Безопасность') ?></h2>
            <span class="select-text">
<?= Lang::t('Организатор тура обеспечивает безопасность каждого участника. Гид и/или сотрудник по безопасности имеет сертификат оказания первой помощи, а так же имеет при себе средства оказания первой медицинской помощи.') ?>
            <p>
                <span class="select-row"><i class="fas fa-phone-alt"></i> <?= Lang::t('Единый номер экстренных служб') ?>: <span class="select-item">112</span></span>
            </p>
            </span>
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