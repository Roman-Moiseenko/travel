<?php

use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\Emoji;
use booking\helpers\SysHelper;
use booking\helpers\tours\TourHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\design\BtnGeo;
use frontend\widgets\design\BtnWish;
use frontend\widgets\GalleryWidget;
use frontend\widgets\LegalWidget;
use frontend\widgets\reviews\NewReviewTourWidget;
use frontend\widgets\RatingWidget;
use frontend\widgets\reviews\ReviewsWidget;
use frontend\widgets\templates\TagsWidget;
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
$this->params['emoji'] = Emoji::TOUR;

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
    <div class="col-md-8 <?= $mobile ? ' ml-2' : '' ?>">
        <!-- Заголовок тура-->
        <div class="row pb-3">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h1><?= Html::encode($tour->getName()) ?></h1>
                    </div>
                    <?= BtnWish::widget(['url' => Url::to(['/cabinet/wishlist/add-tour', 'id' => $tour->id]) ]) ?>
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
    </div>
    <!-- КУПИТЬ БИЛЕТЫ -->
    <?php if (!$mobile): ?>
    <div class="col-md-4 <?= $mobile ? ' ml-2' : '' ?>">
        <?= $this->render('_block_call_up', [
            'tour' => $tour,
        ])?>
    </div>
    <?php endif;?>
</div>
<!-- Стоимость -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr">Стоимость экскурсии</div>
        </div>
        <span class="params-item">
                    <?php if ($tour->baseCost->adult): ?>
                        <i class="fas fa-user"></i>&#160;&#160;
                        <?= $tour->params->private
                        ? (Lang::t('Цена за экскурсию') . ' (' . Lang::t('до') . ' ' . $tour->params->groupMax . ' ' .Lang::t('человек)'))
                        : Lang::t('Взрослый билет') ?>
                        <span class="price-view">
                            <?= CurrencyHelper::get($tour->baseCost->adult) ?>
                        </span>
                    <?php endif; ?>
                </span>
        <p></p>
        <?php if ($tour->isPrivate()):?>
            <?php foreach($tour->capacities as $capacity):?>
                <span class="params-item">
                        <i class="fas fa-user-plus"></i>&#160;&#160;<?= (Lang::t('Цена за экскурсию') . ' (' . Lang::t('до') . ' ' . $capacity->count . ' ' .Lang::t('человек)')) ?>
                        <span class="price-view">
                            <?= '+' . $capacity->percent . '%' ?>
                        </span>
                </span>
                <p></p>
            <?php endforeach; ?>
            <?php if (count($tour->transfers) > 0):?>
                <span class="params-item">
                        <i class="fas fa-car-alt"></i>&#160;&#160;<?= Lang::t('Услуга предоставления трансфера (туда-обратно)') ?>:
                </span>
                <br>
                <?php foreach($tour->transfers as $transfer):?>
                    <span class="params-item">
                        <span class="pl-5"><?= $transfer->from->getName() . '-' . $transfer->to->getName() . ' - '?>
                            <span class="price-view">
                                <?= CurrencyHelper::get($transfer->cost) ?>
                            </span>
                        </span>
                    </span>
                    <br>
                <?php endforeach; ?>
                <p></p>
            <?php endif; ?>


            <?php if (!empty($tour->extra_time_cost)):?>
                <span class="params-item">
                        <i class="fas fa-user-clock"></i>&#160;&#160;<?= Lang::t('Дополнительный час экскурсии') ?>
                        <span
                                class="price-view">
                            <?= CurrencyHelper::get($tour->extra_time_cost) ?>
                        </span>
                </span>
                <p></p>
            <?php endif; ?>
        <?php endif; ?>
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
                    <i class="fas fa-star-of-life"></i>&#160;&#160;<?= Lang::t('Цена экскурсии может меняться в зависимости от даты и времени, актуальную цену уточняйте у гида ') ?>
                </span>
    </div>
</div>
<!-- Параметры -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr">Параметры экскурсии</div>
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
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
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
<!-- КУПИТЬ БИЛЕТЫ -->
<?php if ($mobile): ?>
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <?= $this->render('_block_call_up', [
            'tour' => $tour,
        ])?>
    </div>
</div>
<?php endif;?>
<!-- Координаты -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
                <span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
                      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr">Экскурсия на карте</div>
        </div>
        <div class="params-item-map">
            <div class="row pb-2">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <?= BtnGeo::widget([
                        'caption' => 'Место сбора',
                        'target_id' => 'collapse-map',
                    ]) ?>
                </div>
                <div class="col-sm-6 col-md-8 col-lg-9 align-self-center"
                     id="address"><?= $tour->params->endAddress->address ?? '<span class="badge badge-info">' . Lang::t('Не указано') . '</span>' ?></div>
            </div>
            <div class="collapse" id="collapse-map">
                <div class="card card-body card-map">
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
            <div class="row pb-2">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <?= BtnGeo::widget([
                        'caption' => 'Место окончания',
                        'target_id' => 'collapse-map-2',
                    ]) ?>
                </div>
                <div class="col-sm-6 col-md-8 col-lg-9 align-self-center"
                     id="address-2"><?= $tour->params->endAddress->address ?? '<span class="badge badge-info">' . Lang::t('Не указано') . '</span>' ?></div>
            </div>
            <div class="collapse" id="collapse-map-2">
                <div class="card card-body card-map">
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
            <div class="row pb-2">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <?= BtnGeo::widget([
                        'caption' => 'Место проведение',
                        'target_id' => 'collapse-map-3',
                    ]) ?>
                </div>
                <div class="col-sm-6 col-md-8 col-lg-9 align-self-center"
                     id="address-3"><?= $tour->address->address ?? '<span class="badge badge-info">' . Lang::t('Не указано') . '</span>' ?></div>
            </div>
            <div class="collapse" id="collapse-map-3">
                <div class="card card-body card-map">
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
<div class="row" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <!-- Виджет подгрузки отзывов -->
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><h3 style="font-size: 21px!important; color: #666; font-family: 'Comfortaa', sans-serif;">Отзывы об экскурсии</h3></div>
        </div>
        <div id="review">
            <?= ReviewsWidget::widget(['reviews' => $tour->reviews]); ?>
        </div>
        <?= NewReviewTourWidget::widget(['tour_id' => $tour->id]); ?>
    </div>
</div>
<!--Облако тегов-->
<?= TagsWidget::widget([
    'object' => Tour::class
]) ?>

<div itemtype="https://schema.org/TouristTrip" itemscope>
    <meta itemprop="name" content="<?= Lang::t('Экскурсия ') . $tour->getName() ?>"/>
    <meta itemprop="description" content="<?= strip_tags($tour->getDescription()) ?>"/>
    <?php foreach ($tour->types as $type): ?>
        <meta itemprop="touristType" content="<?= Lang::t($type->name) ?>"/>
    <?php endforeach; ?>
    <meta itemprop="touristType" content="<?= Lang::t($tour->type->name) ?>"/>
    <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
        <meta itemprop="name" content="<?= $tour->getName() ?>"/>
        <meta itemprop="description"
              content="<?= Lang::t('Билет на экскурсию цена за ') . ($tour->params->private ? Lang::t('экскурсию') : Lang::t('1 человека')) ?>"/>
        <meta itemprop="price" content="<?= $tour->baseCost->adult ?>"/>
        <meta itemprop="priceCurrency" content="RUB"/>
        <link itemprop="url" href="<?= Url::to(['/tour/view', 'id' => $tour->id], true) ?>"/>
        <div itemprop="eligibleRegion" itemtype="https://schema.org/Country" itemscope>
            <meta itemprop="name" content="Russia, Kaliningrad"/>
            <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
            <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
            </div>
        </div>
        <?php if ($tour->legal): ?>
        <div itemprop="offeredBy" itemtype="https://schema.org/Organization" itemscope>
            <meta itemprop="name" content="<?= $tour->legal->caption ?>"/>
            <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
            <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
            </div>
            <link itemprop="url" href="<?= Url::to(['legals/view', 'id' => $tour->legal->id], true) ?>"/>
        </div>
        <?php endif;?>
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
