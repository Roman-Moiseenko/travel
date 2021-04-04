<?php

use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use booking\helpers\tours\TourHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\GalleryWidget;
use frontend\widgets\LegalWidget;
use frontend\widgets\reviews\NewReviewTourWidget;
use frontend\widgets\RatingWidget;
use frontend\widgets\reviews\ReviewsWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $tour Tour */
/* @var $reviewForm ReviewForm */

$this->registerMetaTag(['name' => 'description', 'content' => $tour->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $tour->meta->description]);

$this->title = $tour->meta->title ? Lang::t($tour->meta->title) : $tour->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Экскурсии'), 'url' => Url::to(['tours/index'])];
$this->params['breadcrumbs'][] = $tour->getName();

$this->params['canonical'] = Url::to(['/tour/view', 'id' => $tour->id], true);
$this->params['tour'] = true;

MagnificPopupAsset::register($this);
MapAsset::register($this);
$mobile = SysHelper::isMobile();
$countReveiws = $tour->countReviews();

?>
<!-- ФОТО  -->
<div class="pb-4 thumbnails gallery" style="margin-left: 0 !important;"
     xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <?php foreach ($tour->photos as $i => $photo) {
        echo GalleryWidget::widget([
            'photo' => $photo,
            'iterator' => $i,
            'count' => count($tour->photos),
            'name' => $tour->getName(),
            'description' => $tour->description,
        ]);
    } ?>
</div>
<!-- ОПИСАНИЕ -->

<div class="row" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col-sm-8 <?= $mobile ? ' ml-2' : '' ?>">
        <!-- Заголовок тура-->
        <div class="row pb-3">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h1><?= Html::encode($tour->getName()) ?></h1>
                    </div>
                    <div class="btn-group">
                        <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                                title="<?= Lang::t('В избранное') ?>"
                                href="<?= Url::to(['/cabinet/wishlist/add-tour', 'id' => $tour->id]) ?>"
                                data-method="post">
                            <i class="fa fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Описание -->
        <div class="row">
            <div class="col-sm-12 params-tour text-justify">
                <?= Yii::$app->formatter->asHtml($tour->getDescription(), [
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
                    <?php if ($tour->baseCost->adult): ?>
                        <i class="fas fa-user"></i>&#160;&#160;<?= $tour->params->private ? Lang::t('Цена за экскурсию') : Lang::t('Взрослый билет') ?>
                        <span
                                class="price-view">
                            <?= CurrencyHelper::get($tour->baseCost->adult) ?>
                        </span>
                    <?php endif; ?>
                </span>
                <p></p>
                <?php if ($tour->baseCost->child): ?>
                    <span class="params-item">
                    <i class="fas fa-child"></i>&#160;&#160;<?= Lang::t('Детский билет') ?>
                    <span class="price-view">
                        <?= CurrencyHelper::get($tour->baseCost->child) ?>
                    </span>
                </span>
                    <p></p>
                <?php endif; ?>
                <?php if ($tour->baseCost->preference): ?>
                    <span class="params-item">
                    <i class="fab fa-accessible-icon"></i>&#160;&#160;<?= Lang::t('Льготный билет') ?> <span
                                class="price-view">
                    <?= CurrencyHelper::get($tour->baseCost->preference) ?>
                    </span>
                </span>
                    <p></p>
                <?php endif; ?>

                <span class="params-item">
                    <i class="fas fa-star-of-life"></i>&#160;&#160;<?= Lang::t('Цена экскурсии может меняться в зависимости от даты и времени') ?>
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
                    <i class="far fa-clock"></i>&#160;&#160;<?= Lang::duration($tour->params->duration) ?>
                </span>
                <span class="params-item">
                    <?php if ($tour->params->private) {
                        echo '<i class="fas fa-user"></i>&#160;&#160;' . Lang::t('Индивидуальный');
                    } else {
                        echo '<i class="fas fa-users"></i>&#160;&#160;' . Lang::t('Групповой');
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
                    <?php foreach ($tour->extra as $extra): ?>
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
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-outline-secondary loader_ymap" type="button" data-toggle="collapse"
                                    data-target="#collapse-map"
                                    aria-expanded="false" aria-controls="collapse-map">
                                <i class="fas fa-map-marker-alt"></i>
                            </button>&#160;<?= Lang::t('Место сбора') ?>:
                        </div>
                        <div class="col-8 align-self-center"
                             id="address"><?= $tour->params->endAddress->address ?? '<span class="badge badge-info">' . Lang::t('Не указано') . '</span>' ?></div>
                    </div>
                    <div class="collapse" id="collapse-map">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-8">
                                    <input id="bookingaddressform-address" class="form-control" width="100%"
                                           value="<?= $tour->params->beginAddress->address ?? '' ?>" type="hidden">
                                </div>
                                <div class="col-2">
                                    <input id="bookingaddressform-latitude" class="form-control" width="100%"
                                           value="<?= $tour->params->beginAddress->latitude ?? '' ?>" type="hidden">
                                </div>
                                <div class="col-2">
                                    <input id="bookingaddressform-longitude" class="form-control" width="100%"
                                           value="<?= $tour->params->beginAddress->longitude ?? '' ?>" type="hidden">
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

                            <button class="btn btn-outline-secondary loader_ymap" type="button" data-toggle="collapse"
                                    data-target="#collapse-map-2"
                                    aria-expanded="false" aria-controls="collapse-map-2">
                                <i class="fas fa-map-marker-alt"></i>
                            </button>&#160;<?= Lang::t('Место окончания') ?>:
                        </div>
                        <div class="col-8 align-self-center"
                             id="address-2"><?= $tour->params->endAddress->address ?? '<span class="badge badge-info">' . Lang::t('Не указано') . '</span>' ?></div>
                    </div>
                    <div class="collapse" id="collapse-map-2">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-8">
                                    <input id="bookingaddressform-address-2" class="form-control" width="100%"
                                           value="<?= $tour->params->endAddress->address ?? '' ?>" type="hidden">
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

                            <button class="btn btn-outline-secondary loader_ymap" type="button" data-toggle="collapse"
                                    data-target="#collapse-map-3"
                                    aria-expanded="false" aria-controls="collapse-map-2">
                                <i class="fas fa-map-marker-alt"></i>
                            </button>&#160;<?= Lang::t('Место проведение') ?>:
                        </div>
                        <div class="col-8 align-self-center"
                             id="address-3"><?= $tour->address->address ?? '<span class="badge badge-info">' . Lang::t('Не указано') . '</span>' ?></div>
                    </div>
                    <div class="collapse" id="collapse-map-3">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-8">
                                    <input id="bookingaddressform-address-3" class="form-control" width="100%"
                                           value="<?= $tour->address->address ?? '' ?>" type="hidden">
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
        <!-- ОТЗЫВЫ -->
        <div class="row">
            <div class="col">
                <!-- Виджет подгрузки отзывов -->
                <div class="container-hr">
                    <hr/>
                    <div class="text-left-hr"><?= Lang::t('Отзывы') . ' (' . $countReveiws . ')' ?></div>
                </div>
                <div id="review">
                    <?= ReviewsWidget::widget(['reviews' => $tour->reviews]); ?>
                </div>
                <?= NewReviewTourWidget::widget(['tour_id' => $tour->id]); ?>
            </div>
        </div>
    </div>
    <!-- КУПИТЬ БИЛЕТЫ -->
    <div class="col-sm-4 <?= $mobile ? ' ml-2' : '' ?>">
        <div class="row">
            <div class="col">
                <?php if ($tour->isActive()) {
                    echo $this->render('_booking', [
                        'tour' => $tour,
                    ]);
                } else {
                    echo '<span class="badge badge-danger" style="font-size: 16px">' . Lang::t('Тур не активен.') . '<p></p>' . Lang::t('Бронирование недоступно.') . '</span>';
                }
                ?>
                <div class="rating">
                    <p>
                        <?= RatingWidget::widget(['rating' => $tour->rating]); ?>
                        <a href="#review">
                            <?= $countReveiws ?> <?= Lang::t('отзывов') ?>
                        </a>
                        &nbsp;
                    </p>
                    <hr>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?= LegalWidget::widget(['legal' => $tour->legal]) ?>
            </div>
        </div>
    </div>

</div>
<div itemtype="https://schema.org/TouristTrip" itemscope>
    <meta itemprop="name" content="<?= Lang::t('Экскурсия ') . $tour->getName() ?>" />
    <meta itemprop="description" content="<?= strip_tags($tour->getDescription()) ?>" />
    <?php foreach ($tour->types as $type): ?>
        <meta itemprop="touristType" content="<?= Lang::t($type->name) ?>" />
    <?php endforeach; ?>
    <meta itemprop="touristType" content="<?= Lang::t($tour->type->name) ?>" />
    <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
        <meta itemprop="name" content="<?= $tour->getName() ?>" />
        <meta itemprop="description" content="<?= Lang::t('Билет на экскурсию цена за ') .  ($tour->params->private ? Lang::t('экскурсию') : Lang::t('1 человека')) ?>" />
        <meta itemprop="price" content="<?= $tour->baseCost->adult ?>" />
        <meta itemprop="priceCurrency" content="RUB" />
        <link itemprop="url" href="<?= Url::to(['/tour/view', 'id' => $tour->id], true) ?>" />
        <div itemprop="eligibleRegion" itemtype="https://schema.org/Country" itemscope>
            <meta itemprop="name" content="Russia, Kaliningrad" />
        </div>
        <div itemprop="offeredBy" itemtype="https://schema.org/Organization" itemscope>
            <meta itemprop="name" content="<?= $tour->legal->caption ?>" />
            <link itemprop="url" href="<?= Url::to(['legals/view', 'id' => $tour->legal->id], true) ?>" />
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
