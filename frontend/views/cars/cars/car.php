<?php

use booking\entities\booking\cars\Car;
use booking\entities\Lang;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\Emoji;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\design\BtnGeo;
use frontend\widgets\design\BtnWish;
use frontend\widgets\GalleryWidget;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;
use frontend\widgets\reviews\NewReviewCarWidget;
use frontend\widgets\reviews\ReviewsWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $car Car */
/* @var $reviewForm ReviewForm */

$this->registerMetaTag(['name' => 'description', 'content' => $car->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $car->meta->description]);

$this->title = $car->meta->title ? Lang::t($car->meta->title) : $car->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Прокат авто'), 'url' => Url::to(['cars/index'])];
$this->params['breadcrumbs'][] = $this->title;
$this->params['car'] = true;
$this->params['canonical'] = Url::to(['/car/view', 'id' => $car->id], true);

MagnificPopupAsset::register($this);
MapAsset::register($this);

$mobile = SysHelper::isMobile();

$countReveiws = $car->countReviews();
$this->params['emoji'] = Emoji::CAR;
?>
<!-- ФОТО  -->
<div class="pb-4 thumbnails gallery" style="margin-left: 0 !important;"
     xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <?php foreach ($car->photos as $i => $photo) {
        echo GalleryWidget::widget([
            'photo' => $photo,
            'iterator' => $i,
            'count' => count($car->photos),
            'name' => $car->getName(),
            'description' => $car->description,
        ]);
    } ?>
</div>
<!-- ОПИСАНИЕ -->
<div class="row pt-2" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col-sm-8 <?= $mobile ? ' ml-2' : '' ?>">
        <!-- Заголовок авто-->
        <div class="row pb-3">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h1><?= Html::encode($car->getName()) ?></h1>
                    </div>
                    <?= BtnWish::widget(['url' => Url::to(['/cabinet/wishlist/add-car', 'id' => $car->id]) ]) ?>
                </div>
            </div>
        </div>
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
    </div>
    <!-- КУПИТЬ БИЛЕТЫ -->
    <?php if (!$mobile): ?>
        <div class="col-sm-4 <?= $mobile ? ' ml-2' : '' ?>">
            <?= $this->render('_block_booking', [
                'car' => $car,
            ])?>
        </div>
    <?php endif;?>
</div>

<!-- Стоимость -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?> params-tour">
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
        <?php if ($car->discount_of_days): ?>
            <span class="params-item">
                        <i class="fas fa-percent"></i>&#160;&#160;<?= Lang::t('Скидка при прокате более чем на 3 суток') . ' - ' ?> <span
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
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?> params-tour">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><?= Lang::t('Параметры') ?></div>
        </div>
        <span class="params-item">
                    <i class="fas fa-hourglass-start"></i>&#160;&#160;
                    <?= Lang::t('Минимальное бронирование ') . $car->params->min_rent . Lang::t(' д') ?>
                </span>
        <span class="params-item">
                    <i class="fas fa-id-card"></i>&#160;&#160;
                    <?= Lang::t('Категория прав: ') . (($car->params->license == 'none') ? Lang::t('не требуются') : $car->params->license) ?>
                </span>
        <?php if ($car->params->experience != 0): ?>
            <span class="params-item">
                    <i class="fas fa-walking"></i>&#160;&#160;
                    <?= Lang::t('Требуется стаж (лет): ') . $car->params->experience ?>
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
    <div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <div class="col <?= $mobile ? ' ml-2' : '' ?> params-tour">
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Характеристики') ?></div>
            </div>
            <?php foreach ($car->values as $value): ?>
                <span class="params-item">
                    <i class="fas fa-dot-circle"></i>&#160;&#160;
                    <?= Lang::t($value->characteristic->name) . ': ' . $value->value ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<!-- Дополнения -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
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
<!-- КУПИТЬ БИЛЕТЫ -->
<?php if ($mobile): ?>
    <div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <div class="col <?= $mobile ? ' ml-2' : '' ?>">
            <?= $this->render('_block_booking', [
                'car' => $car,
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
            <div class="text-left-hr"><?= Lang::t('Координаты') ?></div>
        </div>
        <div class="params-item-map">
            <div class="row pb-2">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <?= BtnGeo::widget([
                        'caption' => 'Точки проката',
                        'target_id' => 'collapse-map',
                    ]) ?>
                </div>
                <div class="col-sm-6 col-md-8 col-lg-9" id="address"></div>
            </div>
            <div class="collapse" id="collapse-map">
                <div class="card card-body card-map">
                    <div id="count-points" data-count="<?= count($car->address) ?>">
                        <?php foreach ($car->address as $i => $address): ?>
                            <input type="hidden" id="address-<?= ($i + 1) ?>" value="<?= $address->address ?>">
                            <input type="hidden" id="latitude-<?= ($i + 1) ?>"
                                   value="<?= $address->latitude ?>">
                            <input type="hidden" id="longitude-<?= ($i + 1) ?>"
                                   value="<?= $address->longitude ?>">
                        <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <div id="map-car-view" style="width: 100%; height: 300px"></div>
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
            <div class="text-left-hr"><?= Lang::t('Отзывы') . ' (' . $countReveiws . ')' ?></div>
        </div>
        <div id="review">
            <?= ReviewsWidget::widget(['reviews' => $car->reviews]); ?>
        </div>
        <?= NewReviewCarWidget::widget(['car_id' => $car->id]); ?>
    </div>
</div>

<div itemtype="https://schema.org/Offer" itemscope>
    <meta itemprop="name" content="<?= $car->getName() ?>" />
    <meta itemprop="description" content="<?= Lang::t('Прокат авто') ?>" />
    <meta itemprop="price" content="<?= $car->cost ?>" />
    <meta itemprop="priceCurrency" content="RUB" />
    <link itemprop="url" href="<?= Url::to(['/car/view', 'id' => $car->id], true) ?>" />
    <div itemprop="eligibleRegion" itemtype="https://schema.org/Country" itemscope>
        <meta itemprop="name" content="Russia, Kaliningrad" />
        <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
        <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
            <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
            <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
            <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
        </div>
    </div>
    <div itemprop="offeredBy" itemtype="https://schema.org/Organization" itemscope>
        <meta itemprop="name" content="<?= $car->legal->caption ?>" />
        <link itemprop="url" href="<?= Url::to(['legals/view', 'id' => $car->legal->id], true) ?>" />
        <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
        <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
            <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
            <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
            <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
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
