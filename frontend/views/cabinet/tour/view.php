<?php

use booking\entities\user\User;

/* @var $booking BookingTour */

/* @var $user User */

use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use booking\helpers\tours\TourHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\cabinet\CheckBookingWidget;
use frontend\widgets\design\BtnCancel;
use frontend\widgets\design\BtnGeo;
use frontend\widgets\design\BtnPay;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $booking->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Мои бронирования'), 'url' => Url::to(['cabinet/booking/index'])];;
$this->params['breadcrumbs'][] = $this->title;

MagnificPopupAsset::register($this);
MapAsset::register($this);
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
            <a href="<?= $booking->getLinks()->entities; ?>"><?= $tour->getName() ?></a>

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
                        <th><?= Lang::t('Дата тура') ?>:</th>
                        <td colspan="3"><?= date('d-m-Y', $booking->calendar->tour_at) ?></td>
                    </tr>
                    <tr>
                        <th><?= Lang::t('Время начало') ?>:</th>
                        <td colspan="3"><?= $booking->calendar->time_at ?></td>
                    </tr>
                    <?php if (!$tour->params->private): ?>
                        <?php if ($booking->count->adult !== 0): ?>
                            <tr>
                                <th><?= Lang::t('Взрослый билет') ?></th>
                                <td><?= $booking->count->adult ?> шт</td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($booking->count->child !== 0): ?>
                            <tr>
                                <th><?= Lang::t('Детский билет') ?></th>
                                <td><?= $booking->count->child ?> <?= Lang::t('шт') ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($booking->count->preference !== 0): ?>
                            <tr>
                                <th><?= Lang::t('Льготный билет') ?></th>
                                <td><?= $booking->count->preference ?> <?= Lang::t('шт') ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>

                    <tr></tr>
                    <tr class="price-view py-2 my-2">
                        <th class="py-3 my-2"><?= $tour->params->private ? Lang::t('Стоимость экскурсии') : Lang::t('Сумма платежа') ?></th>
                        <td></td>
                        <td></td>
                        <td style="font-size: 22px; color: #333"><span
                                    class=""><?= CurrencyHelper::get($booking->getPayment()->getFull()) ?> </span></td>
                    </tr>
                    <tr class="price-view py-2 my-2">
                        <th class="py-3 my-2"><?= Lang::t('Предоплата') . ' (' . $booking->getPayment()->percent . '%)' ?></th>
                        <td></td>
                        <td></td>
                        <td style="font-size: 22px; color: #333">
                            <span><?= CurrencyHelper::stat($booking->getPayment()->getPrepay()) ?> </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php if ($booking->isNew()): ?>
                    <div class="d-flex pay-tour py-3">
                        <div>
                            <?= BtnCancel::widget([
                                'url' => Url::to(['/cabinet/tour/delete', 'id' => $booking->id]),
                            ]) ?>
                        </div>
                        <div class="ml-auto">
                            <?= BtnPay::widget([
                                'url' => Url::to(['/cabinet/pay/tour', 'id' => $booking->id]),
                                'paid_locality' => $booking->isPaidLocally(),
                            ]) ?>
                        </div>
                    </div>
                    <div style="font-size: 12px">
                        <?= Lang::t('* При предоплате, оставшаяся часть оплачивается на месте') ?><br>
                        <?php if ($booking->isPaidLocally()): ?>
                            <?= Lang::t('* Подтверждение бронирования - бесплатно. Оплачивайте туры на месте.') ?>
                        <?php else: ?>
                            <?= Lang::t('* Перед оплатой бронирования, ознакомьтесь с нашей') . ' ' . Html::a(Lang::t('Политикой возврата'), Url::to(['/refund'])) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Чеки и бронь -->
        <?= CheckBookingWidget::widget([
            'action' => 'tour',
            'user' => $user,
            'booking' => $booking,
        ]) ?>
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
                            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
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
                    <i class="far fa-clock"></i>&#160;&#160;<?= Lang::duration($tour->params->duration) ?>
                </span>
                    <span class="params-item">
                    <?php if ($tour->params->private) {
                        echo '<i class="fas fa-user"></i>&#160;&#160;' . Lang::t('Индивидуальный');
                    } else {
                        echo '<i class="fas fa-users"></i>&#160;&#160; ' . Lang::t('Групповой');
                    }
                    ?>
                </span>
                    <span class="params-item">
                    <i class="fas fa-user-friends"></i>&#160;&#160;<?= TourHelper::group($tour->params->groupMin, $tour->params->groupMax) ?>
                </span>
                    <span class="params-item">
                    <i class="fas fa-user-clock"></i>&#160;&#160;<?= Lang::t('Ограничения по возрасту') . ' ' . BookingHelper::ageLimit($tour->params->agelimit) ?>
                </span>
                    <span class="params-item">
                    <i class="fas fa-ban"></i>&#160;&#160;<?= BookingHelper::cancellation($tour->cancellation) ?>
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
                                    'caption' => 'Место сбора',
                                    'target_id' => 'collapse-map',
                                ]) ?>
                            </div>
                            <div class="col-8"><?= $tour->params->beginAddress->address ?? ' ' ?></div>
                        </div>
                        <div class="collapse" id="collapse-map">
                            <div class="card card-body card-map">
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
                        <div class="row pb-2">
                            <div class="col-4">
                                <?= BtnGeo::widget([
                                    'caption' => 'Место окончания',
                                    'target_id' => 'collapse-map-2',
                                ]) ?>
                            </div>
                            <div class="col-8"><?= $tour->params->endAddress->address ?></div>
                        </div>
                        <div class="collapse" id="collapse-map-2">
                            <div class="card card-body card-map">
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
                        <div class="row pb-2">
                            <div class="col-4">
                                <?= BtnGeo::widget([
                                    'caption' => 'Место проведение',
                                    'target_id' => 'collapse-map-3',
                                ]) ?>
                            </div>
                            <div class="col-8"><?= $tour->address->address ?? ' ' ?></div>
                        </div>
                        <div class="collapse" id="collapse-map-3">
                            <div class="card card-body card-map">
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
                <span class="select-row"><i
                            class="fas fa-phone-alt"></i> <?= Lang::t('Единый номер экстренных служб') ?>: <span
                            class="select-item">112</span></span>
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