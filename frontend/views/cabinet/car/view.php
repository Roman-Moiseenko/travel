<?php

use booking\entities\booking\cars\BookingCar;
use booking\entities\user\User;

/* @var $booking BookingCar */

/* @var $user User */

use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\tours\TourHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\LegalWidget;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $booking->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Мои бронирования'), 'url' => Url::to(['cabinet/booking/index'])];;
$this->params['breadcrumbs'][] = $this->title;

MapAsset::register($this);
MagnificPopupAsset::register($this);
$car = $booking->car;
?>
    <!-- Фото + Название + Ссылка -->
    <div class="d-flex p-2">
        <div>
            <ul class="thumbnails">
                <li>
                    <a class="thumbnail"
                       href="<?= $car->mainPhoto->getThumbFileUrl('file', 'catalog_origin'); ?>">
                        <img src="<?= $car->mainPhoto->getThumbFileUrl('file', 'cabinet_list'); ?>"
                             alt="<?= Html::encode($car->getName()); ?>"/></a>
                </li>
            </ul>
        </div>
        <div class="flex-grow-1 align-self-center caption-list pl-3">
            <a href="<?= $booking->getLinks()['entities']; ?>"><?= $car->getName() ?></a>

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
                        <th><?= Lang::t('Прокат') ?>:</th>
                        <td colspan="3"><?= date('d-m-Y', $booking->begin_at) ?></td>
                    </tr>
                    <tr>
                        <th><?= ''; ?></th>
                        <td colspan="3"><?= date('d-m-Y', $booking->end_at) ?></td>
                    </tr>
                        <tr>
                            <th><?= Lang::t('Транспортное средство') ?></th>
                            <td><?= $booking->quantity() ?> шт</td>
                        </tr>

                    <tr></tr>
                    <tr class="price-view py-2 my-2">
                        <th class="py-3 my-2"><?= Lang::t('Сумма платежа') ?></th>
                        <td></td>
                        <td></td>
                        <td style="font-size: 22px;"><span class=""><?= CurrencyHelper::get($booking->getPayment()->getFull()) ?> </span></td>

                    </tr>
                    <tr class="price-view py-2 my-2">
                        <th class="py-3 my-2"><?= Lang::t('Предоплата') . ' ('. $booking->getPayment()->percent . '%)' ?></th>
                        <td></td>
                        <td></td>
                        <td style="font-size: 26px;"><span class="badge badge-info"><?= CurrencyHelper::stat($booking->getPayment()->getPrepay())?> </span></td>
                    </tr>
                    </tbody>
                </table>
                <?php if ($booking->isNew()): ?>
                    <div class="d-flex pay-tour py-3">
                        <div>
                            <a href="<?= Url::to(['/cabinet/car/delete', 'id' => $booking->id]) ?>"
                               class="btn-lg btn-warning"><?= Lang::t('Отменить') ?></a>
                        </div>
                        <div class="ml-auto">
                            <a href="<?= Url::to(['/cabinet/pay/car', 'id' => $booking->id]) ?>"
                               class="btn-lg btn-primary">
                                <?= Lang::t(($booking->isPaidLocally()) ? 'Подтвердить' : 'Оплатить') ?>
                            </a>
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
        <?php if ($booking->isPay()): ?>
            <div class="card shadow-sm py-2 my-2">
                <div class="card-body nowrap-parent">
                    <h2 style="white-space: normal !important;"><?= Lang::t('Ваше бронирование оплачено') ?>!</h2>
                    <ul class="reassurance__list">
                        <li style="white-space: normal !important;">
                            <?= Lang::t('Подтверждение бронирования отправлено на ваш адрес') ?>
                            <b><?= $user->email ?></b>
                        </li>
                        <li>
                            <div class="nowrap-child">
                                <?= Lang::t('Распечатать подтверждение') ?>
                                <a class="btn-sm btn-primary "
                                   href="<?= Url::to(['/cabinet/print/car', 'id' => $booking->id]) ?>">
                                    <i class="fas fa-print"></i></a>
                            </div>
                        </li>
                            <li>
                                <?= Lang::t('Распечатать чек об оплате')  ?>
                                <a class="btn-sm btn-primary"
                               href="<?= Url::to(['/cabinet/print/check', 'id' => $booking->payment_id]) ?>">
                                <i class="fas fa-print"></i></a>
                            </li>
                    </ul>
                    <?php if ($booking->car->isCancellation($booking->begin_at)): ?>
                        <div class="py-3">
                            <a href="<?= Url::to(['/cabinet/car/cancelpay', 'id' => $booking->id]) ?>"
                               class="btn-lg btn-warning"><?= Lang::t('Отменить бронирование') ?> *</a>
                        </div>
                        <label>* <?= Lang::t('В случае отмены платежа комиссия банка не возвращается') ?></label>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($booking->isConfirmation()): ?>
            <div class="card shadow-sm py-2 my-2">
                <div class="card-body nowrap-parent">
                    <h2 style="white-space: normal !important;"><?= Lang::t('Ваше бронирование подтверждено') ?>!</h2>
                    <ul class="reassurance__list">
                        <li style="white-space: normal !important;">
                            <?= Lang::t('Подтверждение бронирования отправлено на ваш адрес') ?>
                            <b><?= $user->email ?></b>
                        </li>
                        <li>
                            <div class="nowrap-child">
                                <?= Lang::t('Распечатать подтверждение') ?>
                                <a class="btn-sm btn-primary "
                                   href="<?= Url::to(['/cabinet/print/car', 'id' => $booking->id]) ?>">
                                    <i class="fas fa-print"></i></a>
                            </div>
                        </li>
                    </ul>
                    <?php if ($booking->begin_at > time()): ?>
                        <div class="pt-3">
                            <a href="<?= Url::to(['/cabinet/car/delete', 'id' => $booking->id]) ?>"
                               class="btn-lg btn-warning"><?= Lang::t('Отменить бронирование') ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <!-- Информация об авто -->
    <div class="card shadow-sm my-2">
        <div class="card-body">
            <!-- Описание -->
            <div class="row">
                <div class="col-sm-12 params-tour text-justify">
                    <?= Yii::$app->formatter->asHtml($car->getDescription(), [
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
                        <i class="fas fa-car"></i>&#160;&#160;<?= Lang::t('Цена в сутки') ?> <span
                                class="price-view">
                            <?= CurrencyHelper::get($car->cost) ?>
                        </span>
                    </span>
                    <p></p>

                    <span class="params-item">
                        <i class="fas fa-wallet"></i>&#160;&#160;<?= Lang::t('Залог') ?> <span
                                class="price-view">
                            <?= CurrencyHelper::get($car->deposit) ?>
                        </span>
                    </span>
                    <p></p>
                    <?php if ($car->discount_of_days):?>
                        <span class="params-item">
                        <i class="fas fa-percent"></i>&#160;&#160;<?= Lang::t('Скидка при прокате более чем на 3 суток') . ' - '?> <span
                                    class="price-view">
                            <?= $car->discount_of_days . ' %' ?>
                        </span>
                    </span>
                        <p></p>
                    <?php endif; ?>
                    <span class="params-item">
                    <i class="fas fa-star-of-life"></i>&#160;&#160;<?= Lang::t('Стоимость проката может меняться в зависимости от даты') ?>
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
                    <i class="fas fa-hourglass-start"></i>&#160;&#160;
                    <?= Lang::t('Минимальное бронирование ') . $car->params->min_rent . Lang::t(' д')?>
                </span>
                    <span class="params-item">
                    <i class="fas fa-id-card"></i>&#160;&#160;
                    <?= Lang::t('Категория прав: ') . (($car->params->license == 'none') ? Lang::t('не требуются') : $car->params->license)?>
                </span>
                    <?php if ($car->params->experience != 0): ?>
                        <span class="params-item">
                    <i class="fas fa-walking"></i>&#160;&#160;
                    <?= Lang::t('Требуется стаж (лет): ') . $car->params->experience?>
                    </span>
                    <?php endif; ?>
                    <span class="params-item">
                    <i class="fas fa-user-clock"></i>&#160;&#160;<?= Lang::t('Ограничения по возрасту') . ' ' . BookingHelper::ageLimit($car->params->age) ?>
                </span>
                    <span class="params-item">
                    <i class="fas fa-ban"></i>&#160;&#160;<?= BookingHelper::cancellation($car->cancellation) ?>
                </span>

                </div>
            </div>
            <!-- Характеристики -->
            <?php if ($car->values): ?>
                <div class="row pt-4">
                    <div class="col params-tour">
                        <div class="container-hr">
                            <hr/>
                            <div class="text-left-hr"><?= Lang::t('Характеристики') ?></div>
                        </div>
                        <?php foreach ($car->values as $value): ?>
                            <span class="params-item">
                    <i class="fas fa-dot-circle"></i>&#160;&#160;
                    <?=  Lang::t($value->characteristic->name) . ': ' . $value->value ?>
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
                        <?php foreach ($car->extra as $extra): ?>
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
                                </button>&#160;<?= Lang::t('Точки проката') ?>:
                            </div>
                            <div class="col-8" id="address"></div>
                        </div>
                        <div class="collapse" id="collapse-map">
                            <div class="card card-body">
                                <div id="count-points" data-count="<?= count($car->address)?>">
                                    <?php foreach ($car->address as $i => $address): ?>
                                        <input type="hidden" id="address-<?= ($i+1)?>" value="<?= $address->address?>">
                                        <input type="hidden" id="latitude-<?= ($i+1)?>" value="<?= $address->latitude?>">
                                        <input type="hidden" id="longitude-<?= ($i+1)?>" value="<?= $address->longitude?>">
                                    <?php endforeach;?>
                                </div>
                                <div class="row">
                                    <div id="map-car-view" style="width: 100%; height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Безопасность -->
    <div class="card py-2 shadow-sm my-2">
        <div class="card-body">
            <h2><?= Lang::t('Безопасность') ?></h2>
            <span class="select-text">
<?= Lang::t('Организатор проката обеспечивает безопасность каждого транспортного средства - гарантирует, что сдаваемое в прокат транспортное средство безопасно. А так же, в случае необходимости имеет страховой полис.') ?>
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