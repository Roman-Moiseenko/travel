<?php

use booking\entities\booking\funs\BookingFun;
use booking\entities\user\User;
use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\funs\WorkModeHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\cabinet\CheckBookingWidget;
use frontend\widgets\design\BtnCancel;
use frontend\widgets\design\BtnGeo;
use frontend\widgets\design\BtnPay;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $booking BookingFun */

/* @var $user User */
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);



$this->title = $booking->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Мои бронирования'), 'url' => Url::to(['cabinet/booking/index'])];;
$this->params['breadcrumbs'][] = $this->title;

MagnificPopupAsset::register($this);
MapAsset::register($this);

$fun = $booking->fun;
$cost_fun = $booking->getCostClass();
?>
    <!-- Фото + Название + Ссылка -->
    <div class="d-flex p-2">
        <div>
            <ul class="thumbnails">
                <li>
                    <a class="thumbnail"
                       href="<?= $fun->mainPhoto->getThumbFileUrl('file', 'catalog_origin'); ?>">
                        <img src="<?= $fun->mainPhoto->getThumbFileUrl('file', 'cabinet_list'); ?>"
                             alt="<?= Html::encode($fun->getName()); ?>"/></a>
                </li>
            </ul>
        </div>
        <div class="flex-grow-1 align-self-center caption-list pl-3">
            <a href="<?= $booking->getLinks()->entities; ?>"><?= $fun->getName() ?></a>

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
                        <th><?= Lang::t('Дата Мероприятия') ?>:</th>
                        <td colspan="3"><?= date('d-m-Y', $booking->getDate()) ?></td>
                    </tr>
                    <tr>
                        <th><?= Lang::t('Время') ?>:</th>
                        <td colspan="3"><?= $booking->getAdd() ?></td>
                    </tr>
                    <?php if ($booking->count->adult !== 0): ?>
                        <tr>
                            <th width="40%"><?= Lang::t('Взрослый билет') ?></th>
                            <td width="20%"><?= $booking->count->adult ?> шт</td>
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
                    <tr></tr>
                    <tr class="price-view py-2 my-2">
                        <th class="py-3 my-2"><?= Lang::t('Сумма платежа') ?></th>
                        <td></td>
                        <td></td>
                        <td style="font-size: 22px; color: #333;"><?= CurrencyHelper::get($booking->getPayment()->getFull()) ?></td>
                    </tr>
                    <tr class="price-view py-2 my-2">
                        <th class="py-3 my-2"><?= Lang::t('Предоплата') . ' ('. $booking->getPayment()->percent . '%)' ?></th>
                        <td></td>
                        <td></td>
                        <td style="font-size: 22px; color: #333;"><?= CurrencyHelper::stat($booking->getPayment()->getPrepay())?></td>
                    </tr>
                    </tbody>
                </table>
                <?php if ($booking->isNew()): ?>
                    <div class="d-flex pay-tour py-3">
                        <div>
                            <?= BtnCancel::widget([
                                'url' => Url::to(['/cabinet/fun/delete', 'id' => $booking->id]),
                            ]) ?>
                        </div>
                        <div class="ml-auto">
                            <?= BtnPay::widget([
                                'url' =>  Url::to(['/cabinet/pay/fun', 'id' => $booking->id]),
                                'paid_locality' => $booking->isPaidLocally(),
                            ])?>
                        </div>
                    </div>
                    <div style="font-size: 12px">
                        <?= Lang::t('* При предоплате, оставшаяся часть оплачивается на месте') ?><br>
                        <?php if ($booking->isPaidLocally()): ?>
                            <?= Lang::t('* Подтверждение бронирования - бесплатно. Оплачивайте мероприятие на месте.') ?>
                        <?php else: ?>
                            <?= Lang::t('* Перед оплатой бронирования, ознакомьтесь с нашей') . ' ' . Html::a(Lang::t('Политикой возврата'), Url::to(['/refund'])) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Чеки и бронь -->
        <?= CheckBookingWidget::widget([
            'action' => 'fun',
            'user' => $user,
            'booking' => $booking,
        ]) ?>
    </div>
    <!-- Информация о развлечении -->
    <div class="card shadow-sm my-2">
        <div class="card-body">
            <!-- Заголовок Развлечения-->
            <div class="row pb-3">
                <div class="col-12">
                    <div class="align-items-center">
                            <h1><?= Html::encode($fun->getName()) ?></h1>
                    </div>
                </div>
            </div>
            <!-- Описание -->
            <div class="row">
                <div class="col-sm-12 params-tour text-justify">
                    <?= Yii::$app->formatter->asHtml($fun->getDescription(), [
                        'Attr.AllowedRel' => array('nofollow'),
                        'HTML.SafeObject' => true,
                        'Output.FlashCompat' => true,
                        'HTML.SafeIframe' => true,
                        'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                    ]) ?>

                </div>
            </div>
            <!-- Стоимость -->
            <div class="row pt-4">
                <div class="col params-tour">
                    <div class="container-hr">
                        <hr/>
                        <div class="text-left-hr"><?= Lang::t('Стоимость') ?></div>
                    </div>
                    <span class="params-item">
                    <?php if ($fun->baseCost->adult): ?>
                        <i class="fas fa-user"></i>&#160;&#160;<?= Lang::t('Взрослый билет') ?> <span
                                class="price-view">
                            <?= CurrencyHelper::get($fun->baseCost->adult) ?>
                        </span>
                    <?php endif; ?>
                </span>
                    <p></p>
                    <span class="params-item">
                    <?php if ($fun->baseCost->child): ?>
                        <i class="fas fa-child"></i>&#160;&#160;<?= Lang::t('Детский билет') ?> <span
                                class="price-view">
                        <?= CurrencyHelper::get($fun->baseCost->child) ?>
                        </span>
                    <?php endif; ?>
                </span>
                    <p></p>
                    <span class="params-item">
                    <?php if ($fun->baseCost->preference): ?>
                        <i class="fab fa-accessible-icon"></i>&#160;&#160;<?= Lang::t('Льготный билет') ?> <span
                                class="price-view">
                        <?= CurrencyHelper::get($fun->baseCost->preference) ?>
                        </span>
                    <?php endif; ?>
                </span>
                    <p></p>

                    <span class="params-item">
                    <i class="fas fa-star-of-life"></i>&#160;&#160;<?= Lang::t('Стоимость билета может меняться в зависимости от даты') ?>
                </span>
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
                    <i class="fas fa-user-clock"></i>&#160;&#160;<?= Lang::t('Ограничения по возрасту') . ' ' . BookingHelper::ageLimit($fun->params->ageLimit) ?>
                </span>
                    <span class="params-item">
                    <i class="fas fa-ban"></i>&#160;&#160;<?= BookingHelper::cancellation($fun->cancellation) ?>
                </span>
                    <!-- Режим работы -->
                    <span class="params-item">
                    <i class="fas fa-hot-tub"></i>&#160;&#160; <?= Lang::t('Режим работы') ?><br><?= WorkModeHelper::weekMode($fun->params->workMode) ?>
                </span>


                </div>
            </div>
            <!-- Характеристики -->
            <?php if ($fun->values): ?>
                <div class="row pt-4">
                    <div class="col params-tour">
                        <div class="container-hr">
                            <hr/>
                            <div class="text-left-hr"><?= Lang::t('Характеристики') ?></div>
                        </div>
                        <?php foreach ($fun->values as $value): ?>
                            <span class="params-item">
                    <i class="fas fa-dot-circle"></i>&#160;&#160;
                    <?= Lang::t($value->characteristic->name) . ': ' . $value->value ?>
                </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <!-- Дополнения -->
            <div class="row pt-4">
                <div class="col">
                    <div class="container-hr">
                        <hr/>
                        <div class="text-left-hr"><?= Lang::t('Дополнения') ?></div>
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                        <?php foreach ($fun->extra as $extra): ?>
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
                            <div class="col-3">
                                <?= BtnGeo::widget([
                                    'caption' => 'Адрес',
                                    'target_id' => 'collapse-map',
                                ]) ?>
                            </div>
                            <div class="col-9 align-self-center" id="address"></div>
                        </div>
                        <div class="collapse" id="collapse-map">
                            <div class="card card-body card-map">

                                <input type="hidden" id="latitude" value="<?= $fun->address->latitude ?>">
                                <input type="hidden" id="longitude" value="<?= $fun->address->longitude ?>">
                                <div class="row">
                                    <div id="map-fun-view" style="width: 100%; height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- Информация о развлечении -->
    <div class="card py-2 shadow-sm my-2">
        <div class="card-body">
            <h2><?= Lang::t('Безопасность') ?></h2>
            <span class="select-text">
        <?= Lang::t('Организатор мероприятия обеспечивает безопасность каждого участника. Организатор и/или сотрудник по безопасности имеет сертификат оказания первой помощи, а так же имеет при себе средства оказания первой медицинской помощи.') ?>
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