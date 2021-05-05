<?php

use booking\entities\booking\funs\Fun;
use booking\entities\Lang;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\funs\WorkModeHelper;
use booking\helpers\SysHelper;
use frontend\assets\FunAsset;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\design\BtnGeo;
use frontend\widgets\GalleryWidget;
use frontend\widgets\LegalWidget;
use frontend\widgets\RatingWidget;
use frontend\widgets\reviews\NewReviewFunWidget;
use frontend\widgets\reviews\ReviewsWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $fun Fun */
/* @var $reviewForm ReviewForm */

$this->registerMetaTag(['name' => 'description', 'content' => $fun->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $fun->meta->description]);

$this->title = $fun->meta->title ? Lang::t($fun->meta->title) : $fun->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Развлечения и мероприятия'), 'url' => Url::to(['funs/index'])];
$this->params['breadcrumbs'][] = $this->title;
$this->params['canonical'] = Url::to(['/fun/view', 'id' => $fun->id], true);

$this->params['fun'] = true;
//FunAsset::register($this);
MagnificPopupAsset::register($this);
MapAsset::register($this);
$mobile = SysHelper::isMobile();
$countReveiws = $fun->countReviews();
?>
<!-- ФОТО  -->
<div class="pb-4 thumbnails gallery" style="margin-left: 0 !important;"
     xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <?php foreach ($fun->photos as $i => $photo) {
        echo GalleryWidget::widget([
            'photo' => $photo,
            'iterator' => $i,
            'count' => count($fun->photos),
            'name' => $fun->getName(),
            'description' => $fun->description,
        ]);
    } ?>
</div>
<!-- ОПИСАНИЕ -->
<div class="row pt-2" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col-sm-8 <?= $mobile ? ' ml-2' : '' ?>">
        <!-- Заголовок Развлечения-->
        <div class="row pb-3">
            <div class="col-12">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h1><?= Html::encode($fun->getName()) ?></h1>
                    </div>
                    <div class="btn-group">
                        <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                                title="<?= Lang::t('В избранное') ?>"
                                href="<?= Url::to(['/cabinet/wishlist/add-fun', 'id' => $fun->id]) ?>"
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
                <?= Yii::$app->formatter->asHtml($fun->getDescription(), [
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
            'fun' => $fun,
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
                    <?php if ($fun->baseCost->adult): ?>
                        <i class="fas fa-user"></i>&#160;&#160;<?= Lang::t('Взрослый билет') ?> <span
                                class="price-view">
                            <?= CurrencyHelper::get($fun->baseCost->adult) ?>
                        </span>
                    <?php endif; ?>
                </span>
        <p></p>
        <?php if ($fun->baseCost->child): ?>
            <span class="params-item">
                    <i class="fas fa-child"></i>&#160;&#160;<?= Lang::t('Детский билет') ?>
                    <span class="price-view">
                        <?= CurrencyHelper::get($fun->baseCost->child) ?>
                    </span>
                </span>
            <p></p>
        <?php endif; ?>
        <?php if ($fun->baseCost->preference): ?>
            <span class="params-item">
                    <i class="fab fa-accessible-icon"></i>&#160;&#160;<?= Lang::t('Льготный билет') ?> <span
                        class="price-view">
                    <?= CurrencyHelper::get($fun->baseCost->preference) ?>
                    </span>
                </span>
            <p></p>
        <?php endif; ?>

        <span class="params-item">
                    <i class="fas fa-star-of-life"></i>&#160;&#160;<?= Lang::t('Стоимость билета может меняться в зависимости от даты') ?>
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
    <div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <div class="col <?= $mobile ? ' ml-2' : '' ?> params-tour">
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
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
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
<!-- КУПИТЬ БИЛЕТЫ -->
<?php if ($mobile): ?>
    <div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <div class="col <?= $mobile ? ' ml-2' : '' ?>">
            <?= $this->render('_block_booking', [
                'fun' => $fun,
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
                        'caption' => 'Адрес',
                        'target_id' => 'collapse-map',
                    ]) ?>
                </div>
                <div class="col-sm-6 col-md-8 col-lg-9 align-self-center" id="address"><?= $fun->address->address ?></div>
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
<!-- ОТЗЫВЫ -->
<div class="row" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <!-- Виджет подгрузки отзывов -->
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><?= Lang::t('Отзывы') . ' (' . $countReveiws . ')' ?></div>
        </div>
        <div id="review">
            <?= ReviewsWidget::widget(['reviews' => $fun->reviews]); ?>
        </div>
        <?= NewReviewFunWidget::widget(['fun_id' => $fun->id]); ?>
    </div>
</div>

<div itemtype="https://schema.org/TouristTrip" itemscope>
    <meta itemprop="name" content="<?= Lang::t('Мероприятие ') . $fun->getName() ?>" />
    <meta itemprop="description" content="<?= strip_tags($fun->getDescription()) ?>" />
    <meta itemprop="touristType" content="<?= Lang::t($fun->type->name) ?>" />
    <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
        <meta itemprop="name" content="<?= $fun->getName() ?>" />
        <meta itemprop="description" content="<?= Lang::t('Цена за билет') ?>" />
        <meta itemprop="price" content="<?= $fun->baseCost->adult ?>" />
        <meta itemprop="priceCurrency" content="RUB" />
        <link itemprop="url" href="<?= Url::to(['/fun/view', 'id' => $fun->id], true) ?>" />
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
            <meta itemprop="name" content="<?= $fun->legal->caption ?>" />
            <link itemprop="url" href="<?= Url::to(['legals/view', 'id' => $fun->legal->id], true) ?>" />
            <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
            <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
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
