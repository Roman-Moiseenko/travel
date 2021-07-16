<?php

use booking\entities\booking\trips\Trip;
use booking\entities\Lang;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\SysHelper;
use booking\helpers\trips\TripHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\design\BtnGeo;
use frontend\widgets\design\BtnWish;
use frontend\widgets\GalleryWidget;
use frontend\widgets\reviews\NewReviewTripWidget;
use frontend\widgets\reviews\ReviewsWidget;
use lesha724\youtubewidget\Youtube;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $trip Trip */
/* @var $reviewForm ReviewForm */

$this->registerMetaTag(['name' => 'description', 'content' => $trip->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $trip->meta->description]);

$this->title = $trip->meta->title ? Lang::t($trip->meta->title) : $trip->getName();
$this->params['breadcrumbs'][] = ['label' => Lang::t('Туры'), 'url' => Url::to(['trips/index'])];
$this->params['breadcrumbs'][] = $trip->getName();

$this->params['canonical'] = Url::to(['/trip/view', 'id' => $trip->id], true);
$this->params['trip'] = true;

MagnificPopupAsset::register($this);
MapAsset::register($this);
$mobile = SysHelper::isMobile();
$countReveiws = $trip->countReviews();

?>
<!-- ФОТО  -->
<div class="pb-4 thumbnails gallery" style="margin-left: 0 !important;"
     xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <?php foreach ($trip->photos as $i => $photo) {
        echo GalleryWidget::widget([
            'photo' => $photo,
            'iterator' => $i,
            'count' => count($trip->photos),
            'name' => $trip->getName(),
            'description' => $trip->description,
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
                        <h1><?= Html::encode($trip->getName()) ?></h1>
                    </div>
                    <?= BtnWish::widget(['url' => Url::to(['/cabinet/wishlist/add-trip', 'id' => $trip->id])]) ?>
                </div>
            </div>
        </div>
        <!-- Описание -->
        <div class="row">
            <div class="col-sm-12 params-tour text-justify">
                <?= Yii::$app->formatter->asHtml($trip->getDescription(), [
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
            <?= $this->render('_block_booking', [
                'trip' => $trip,
            ]) ?>
        </div>
    <?php endif; ?>
</div>
<!-- Стоимость -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><?= Lang::t('Стоимость') ?></div>
        </div>
        <span class="params-item">
                    <?php if ($trip->cost_base): ?>
                        <i class="fas fa-user"></i>&#160;&#160;
                        <?= Lang::t('Цена за тур') ?>
                        <span class="price-view">
                            <?= CurrencyHelper::get($trip->minAmount()) ?>
                        </span>
                    <?php endif; ?>
                </span>
        <p></p>

        <span class="params-item">
                    <i class="fas fa-star-of-life"></i>&#160;&#160;<?= Lang::t('Цена тура может меняться в зависимости от даты') ?>
                </span>
    </div>
</div>
<!-- Параметры -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><?= Lang::t('Параметры') ?></div>
        </div>
        <span class="params-item">
                    <i class="fas fa-hourglass-half"></i> <?= TripHelper::duration($trip->params->duration) ?>
                </span>
        <span class="params-item">
                    <i class="fas fa-ban"></i>&#160;&#160;<?= BookingHelper::cancellation($trip->cancellation) ?>
                </span>
        <span class="params-item">
                    <i class="fas fa-layer-group"></i>&#160;&#160;
                                    <?php foreach ($trip->types as $type) {
                                        echo Lang::t($type->name) . ' | ';
                                    }
                                    echo Lang::t($trip->type->name); ?>
                </span>
    </div>
</div>

<!-- Программа тура -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><?= Lang::t('Программа тура (мероприятия)') ?></div>
            <div class="pt-3">
                <?php foreach ($trip->activityDayTimeSort() as $day => $times): ?>
                    <p style="font-size: 2rem"><?= Lang::t('День') . ' ' . $day ?></p>
                    <?php foreach ($times as $time => $activities): ?>
                        <?php foreach ($activities as $activity): ?>
                            <h3 style="font-size: 1.5rem;"><?= (empty($time) ? '' : $time) . ' ' . $activity->getCaption(); ?></h3>
                            <div class="ml-4">
                                <?= Yii::$app->formatter->asHtml($activity->description, [
                                    'Attr.AllowedRel' => array('nofollow'),
                                    'HTML.SafeObject' => true,
                                    'Output.FlashCompat' => true,
                                    'HTML.SafeIframe' => true,
                                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                                ]) ?>
                            </div>
                            <div>
                                <ul class="thumbnails">
                                    <?php foreach ($activity->photos as $i => $photo): ?>
                                        <li class="image-additional"><a class="thumbnail"
                                                                        href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>"
                                                                        target="_blank">
                                                <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                                                     alt="<?= $activity->caption; ?>"/>
                                            </a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            <!-- Карта -->
            <div class="row pt-4">
                <div class="col">
                    <span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
                          data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
                    <span id="count-points" data-count="<?= 'count($food->addresses)' ?>"></span>
                    <div class="params-item-map">
                        <div class="row pb-2">
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <?= BtnGeo::widget(['caption' => 'Показать на карте', 'target_id' => 'collapse-map-3']) ?>
                                <?php foreach ($trip->getAddressesActivities() as $i => $address): ?>
                                    <input type="hidden" id="address-<?= $i + 1 ?>" value="<?= $address->address ?>">
                                    <input type="hidden" id="phone-<?= $i + 1 ?>" value="<?= $address->phone ?>">
                                    <input type="hidden" id="latitude-<?= $i + 1 ?>" value="<?= $address->latitude ?>">
                                    <input type="hidden" id="longitude-<?= $i + 1 ?>"
                                           value="<?= $address->longitude ?>">
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="collapse" id="collapse-map-3">
                            <div class="card card-body card-map">
                                <div class="pt-4" id="map-food-view" style="width: 100%; height: 450px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Видео -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><?= Lang::t('Видеообзор') ?></div>
        </div>
        <?php foreach ($trip->videos as $video): ?>
            <h2 class="pt-2"><?= $video->getCaption() ?></h2>
            <?= Youtube::widget([
                'video' => $video->url,
                'iframeOptions' => [ /*for container iframe*/
                    'class' => 'youtube-video'
                ],
                'divOptions' => [ /*for container div*/
                    'class' => 'youtube-video-div'
                ],
                //'height'=> '100%',
                'width' => '100%',
                'playerVars' => [
                    /*https://developers.google.com/youtube/player_parameters?playerVersion=HTML5&hl=ru#playerapiid*/
                    /*	Значения: 0, 1 или 2. Значение по умолчанию: 1. Этот параметр определяет, будут ли отображаться элементы управления проигрывателем. При встраивании IFrame с загрузкой проигрывателя Flash он также определяет, когда элементы управления отображаются в проигрывателе и когда загружается проигрыватель:*/
                    'controls' => 1,
                    /*Значения: 0 или 1. Значение по умолчанию: 0. Определяет, начинается ли воспроизведение исходного видео сразу после загрузки проигрывателя.*/
                    'autoplay' => 0,
                    /*Значения: 0 или 1. Значение по умолчанию: 1. При значении 0 проигрыватель перед началом воспроизведения не выводит информацию о видео, такую как название и автор видео.*/
                    'showinfo' => 0,
                    /*Значение: положительное целое число. Если этот параметр определен, то проигрыватель начинает воспроизведение видео с указанной секунды. Обратите внимание, что, как и для функции seekTo, проигрыватель начинает воспроизведение с ключевого кадра, ближайшего к указанному значению. Это означает, что в некоторых случаях воспроизведение начнется в момент, предшествующий заданному времени (обычно не более чем на 2 секунды).*/
                    'start' => 0,
                    /*Значение: положительное целое число. Этот параметр определяет время, измеряемое в секундах от начала видео, когда проигрыватель должен остановить воспроизведение видео. Обратите внимание на то, что время измеряется с начала видео, а не со значения параметра start или startSeconds, который используется в YouTube Player API для загрузки видео или его добавления в очередь воспроизведения.*/
                    'end' => 0,
                    /*Значения: 0 или 1. Значение по умолчанию: 0. Если значение равно 1, то одиночный проигрыватель будет воспроизводить видео по кругу, в бесконечном цикле. Проигрыватель плейлистов (или пользовательский проигрыватель) воспроизводит по кругу содержимое плейлиста.*/
                    'loop ' => 0,
                    /*тот параметр позволяет использовать проигрыватель YouTube, в котором не отображается логотип YouTube. Установите значение 1, чтобы логотип YouTube не отображался на панели управления. Небольшая текстовая метка YouTube будет отображаться в правом верхнем углу при наведении курсора на проигрыватель во время паузы*/
                    'modestbranding' => 1,
                    /*Значения: 0 или 1. Значение по умолчанию 1 отображает кнопку полноэкранного режима. Значение 0 скрывает кнопку полноэкранного режима.*/
                    'fs' => 1,
                    /*Значения: 0 или 1. Значение по умолчанию: 1. Этот параметр определяет, будут ли воспроизводиться похожие видео после завершения показа исходного видео.*/
                    'rel' => 0,
                    /*Значения: 0 или 1. Значение по умолчанию: 0. Значение 1 отключает клавиши управления проигрывателем. Предусмотрены следующие клавиши управления.
                        Пробел: воспроизведение/пауза
                        Стрелка влево: вернуться на 10% в текущем видео
                        Стрелка вправо: перейти на 10% вперед в текущем видео
                        Стрелка вверх: увеличить громкость
                        Стрелка вниз: уменьшить громкость
                    */
                    'disablekb' => 0
                ],
                'events' => [
                    /*https://developers.google.com/youtube/iframe_api_reference?hl=ru*/
                    'onReady' => 'function (event){
                        /*The API will call this function when the video player is ready*/
                        //event.target.playVideo();
            }',
                ]
            ]); ?>
        <?php endforeach; ?>
    </div>
</div>
<!-- Варианты проживания -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><?= Lang::t('Варианты проживания') ?></div>
        </div>

    </div>
</div>
<!-- КУПИТЬ БИЛЕТЫ -->
<?php if ($mobile): ?>
    <div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <div class="col <?= $mobile ? ' ml-2' : '' ?>">
            <?= $this->render('_block_booking', [
                'trip' => $trip,
            ]) ?>
        </div>
    </div>
<?php endif; ?>

<!-- ОТЗЫВЫ -->
<div class="row" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <!-- Виджет подгрузки отзывов -->
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><h3
                        style="font-size: 21px!important; color: #666; font-family: 'Comfortaa', sans-serif;"><?= Lang::t('Отзывы') ?></h3>
            </div>
        </div>
        <div id="review">
            <?= ReviewsWidget::widget(['reviews' => $trip->reviews]); ?>
        </div>
        <?= NewReviewTripWidget::widget(['trip_id' => $trip->id]); ?>
    </div>
</div>

<div itemtype="https://schema.org/TouristTrip" itemscope>
    <meta itemprop="name" content="<?= Lang::t('Экскурсия ') . $trip->getName() ?>"/>
    <meta itemprop="description" content="<?= strip_tags($trip->getDescription()) ?>"/>
    <?php foreach ($trip->types as $type): ?>
        <meta itemprop="touristType" content="<?= Lang::t($type->name) ?>"/>
    <?php endforeach; ?>
    <meta itemprop="touristType" content="<?= Lang::t($trip->type->name) ?>"/>
    <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
        <meta itemprop="name" content="<?= $trip->getName() ?>"/>
        <meta itemprop="description"
              content="<?= Lang::t('Стоимость тура') ?>"/>
        <meta itemprop="price" content="<?= $trip->minAmount() ?>"/>
        <meta itemprop="priceCurrency" content="RUB"/>
        <link itemprop="url" href="<?= Url::to(['/trip/view', 'id' => $trip->id], true) ?>"/>
        <div itemprop="eligibleRegion" itemtype="https://schema.org/Country" itemscope>
            <meta itemprop="name" content="Russia, Kaliningrad"/>
            <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
            <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
            </div>
        </div>
        <?php if ($trip->legal): ?>
            <div itemprop="offeredBy" itemtype="https://schema.org/Organization" itemscope>
                <meta itemprop="name" content="<?= $trip->legal->caption ?>"/>
                <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
                <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                    <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                    <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                    <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
                </div>
                <link itemprop="url" href="<?= Url::to(['legals/view', 'id' => $trip->legal->id], true) ?>"/>
            </div>
        <?php endif; ?>
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
