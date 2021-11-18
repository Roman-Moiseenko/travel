<?php

use booking\entities\art\event\Event;
use booking\entities\Lang;
use booking\helpers\Emoji;
use booking\helpers\SysHelper;
use frontend\assets\AppAsset;
use frontend\assets\MapAsset;
use frontend\widgets\design\BtnGeo;
use frontend\widgets\TouristicContactWidget;
use lesha724\youtubewidget\Youtube;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $event Event */



$this->registerMetaTag(['name' => 'description', 'content' => $event->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $event->meta->description]);

$this->title = $event->meta->title ? $event->meta->title : $event->name;

$mobile = SysHelper::isMobile();
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => Url::to(['/art/events'])];
$this->params['breadcrumbs'][] = $event->name;
$this->params['emoji'] = Emoji::ART;
AppAsset::register($this);
MapAsset::register($this);
?>

<h1 class="py-2"><?= $event->title ?></h1>

<!-- Фото -->
<?php if ($event->photo): ?>
    <div class="item-responsive item-post item-2-0by1">
        <div class="content-item">
            <img src="<?= Html::encode($event->getThumbFileUrl('photo', 'origin')) ?>"
                 alt="<?= $event->title?>" class="img-responsive-2" itemprop="image" loading="lazy" />
        </div>
    </div>
<?php endif; ?>

<!-- Содержимое -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <?= $event->content ?>
    </div>
</div>

<?php if (!empty($event->video)):?>
<!-- Видео -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr"><?= 'Видеообзор' ?></div>
        </div>
        <?= Youtube::widget([
            'video' => $event->video,
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
    </div>
</div>
<?php endif ?>

<!-- Контакты -->
<div class="row" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
        <!-- Виджет подгрузки отзывов -->
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr">Как с нами связаться</div>
        </div>
        <?= TouristicContactWidget::widget([
            'contact' => $event->contact,
        ]) ?>
    </div>
</div>

<!-- Координаты -->
<div class="row pt-4" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
    <div class="col <?= $mobile ? ' ml-2' : '' ?>">
                <span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
                      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
        <div class="container-hr">
            <hr/>
            <div class="text-left-hr">Где нас найти</div>
        </div>
        <div class="params-item-map">
            <div class="row pb-2">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <?= BtnGeo::widget([
                        'caption' => 'Адрес',
                        'target_id' => 'collapse-map',
                    ]) ?>
                </div>
                <div class="col-sm-6 col-md-8 col-lg-9 align-self-center" id="address"><?= $event->address->address ?></div>
            </div>
            <div class="collapse" id="collapse-map">
                <div class="card card-body card-map">
                    <input type="hidden" id="latitude" value="<?= $event->address->latitude ?>">
                    <input type="hidden" id="longitude" value="<?= $event->address->longitude ?>">
                    <div class="row">
                        <div id="map-fun-view" style="width: 100%; height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

