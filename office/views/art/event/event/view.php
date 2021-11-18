<?php

use booking\entities\art\event\Event;
use booking\helpers\BookingHelper;
use lesha724\youtubewidget\Youtube;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $event Event */

$this->title = $event->name;
$this->params['id'] = $event->id;
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['/art/event/event']];
$this->params['breadcrumbs'][] = $this->title;


?>
<p>
    <?= Html::a('Редактировать', Url::to(['update', 'id' => $event->id]), ['class' => 'btn btn-success']) ?>
</p>
<div class="card card-secondary">
    <div class="card-header with-border">Медиа</div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <a class="pt-4" href="<?= $event->getUploadedFileUrl('photo')?>">
                    <img class="img-responsive-2" src="<?= $event->getThumbFileUrl('photo', 'catalog_list_2_3x')?>" alt=""/>
                </a>
            </div>
            <div class="col-6">
                <?= $event->video?>
                <?= Youtube::widget([
                    'video'=> $event->video,
                    'iframeOptions'=>[ /*for container iframe*/
                        'class'=>'youtube-video'
                    ],
                    'divOptions'=>[ /*for container div*/
                        'class'=>'youtube-video-div'
                    ],
                    'height'=>200,
                    'width'=>300,
                    'playerVars'=>[
                        /*https://developers.google.com/youtube/player_parameters?playerVersion=HTML5&hl=ru#playerapiid*/
                        /*	Значения: 0, 1 или 2. Значение по умолчанию: 1. Этот параметр определяет, будут ли отображаться элементы управления проигрывателем. При встраивании IFrame с загрузкой проигрывателя Flash он также определяет, когда элементы управления отображаются в проигрывателе и когда загружается проигрыватель:*/
                        'controls' => 0,
                        /*Значения: 0 или 1. Значение по умолчанию: 0. Определяет, начинается ли воспроизведение исходного видео сразу после загрузки проигрывателя.*/
                        'autoplay' => 0,
                        /*Значения: 0 или 1. Значение по умолчанию: 1. При значении 0 проигрыватель перед началом воспроизведения не выводит информацию о видео, такую как название и автор видео.*/
                        'showinfo' => 0,
                        /*Значение: положительное целое число. Если этот параметр определен, то проигрыватель начинает воспроизведение видео с указанной секунды. Обратите внимание, что, как и для функции seekTo, проигрыватель начинает воспроизведение с ключевого кадра, ближайшего к указанному значению. Это означает, что в некоторых случаях воспроизведение начнется в момент, предшествующий заданному времени (обычно не более чем на 2 секунды).*/
                        'start'   => 0,
                        /*Значение: положительное целое число. Этот параметр определяет время, измеряемое в секундах от начала видео, когда проигрыватель должен остановить воспроизведение видео. Обратите внимание на то, что время измеряется с начала видео, а не со значения параметра start или startSeconds, который используется в YouTube Player API для загрузки видео или его добавления в очередь воспроизведения.*/
                        'end' => 0,
                        /*Значения: 0 или 1. Значение по умолчанию: 0. Если значение равно 1, то одиночный проигрыватель будет воспроизводить видео по кругу, в бесконечном цикле. Проигрыватель плейлистов (или пользовательский проигрыватель) воспроизводит по кругу содержимое плейлиста.*/
                        'loop ' => 0,
                        /*тот параметр позволяет использовать проигрыватель YouTube, в котором не отображается логотип YouTube. Установите значение 1, чтобы логотип YouTube не отображался на панели управления. Небольшая текстовая метка YouTube будет отображаться в правом верхнем углу при наведении курсора на проигрыватель во время паузы*/
                        'modestbranding'=>  1,
                        /*Значения: 0 или 1. Значение по умолчанию 1 отображает кнопку полноэкранного режима. Значение 0 скрывает кнопку полноэкранного режима.*/
                        'fs'=>1,
                        /*Значения: 0 или 1. Значение по умолчанию: 1. Этот параметр определяет, будут ли воспроизводиться похожие видео после завершения показа исходного видео.*/
                        'rel'=>0,
                        /*Значения: 0 или 1. Значение по умолчанию: 0. Значение 1 отключает клавиши управления проигрывателем. Предусмотрены следующие клавиши управления.
                            Пробел: воспроизведение/пауза
                            Стрелка влево: вернуться на 10% в текущем видео
                            Стрелка вправо: перейти на 10% вперед в текущем видео
                            Стрелка вверх: увеличить громкость
                            Стрелка вниз: уменьшить громкость
                        */
                        'disablekb'=>0
                    ],
                    'events'=>[
                        /*https://developers.google.com/youtube/iframe_api_reference?hl=ru*/
                        'onReady'=> 'function (event){
                        /*The API will call this function when the video player is ready*/
                        //event.target.playVideo();
            }',
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $event,
            'attributes' => [
                [
                    'attribute' => 'name',
                    'label' => 'Название',
                ],
                [
                    'attribute' => 'slug',
                    'label' => 'Ссылка',
                ],
                [
                    'attribute' => 'title',
                    'label' => 'Заголовок',
                ],
                [
                    'attribute' => 'category_id',
                    'value' => ArrayHelper::getValue($event, 'category.name'),
                    'label' => 'Главная категория',
                ],
                [
                    'label' => 'Дополнительные категории',
                    'value' => implode(', ', ArrayHelper::getColumn($event->categories, 'name')),
                ],
            ],
        ]) ?>
    </div>
</div>


<div class="card card-secondary">
    <div class="card-header with-border">Описание</div>
    <div class="card-body">
        <?= Yii::$app->formatter->asHtml($event->description, [
            'Attr.AllowedRel' => array('nofollow'),
            'HTML.SafeObject' => true,
            'Output.FlashCompat' => true,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]) ?>
    </div>
</div>


<div class="card card-secondary">
    <div class="card-header with-border">Расположение</div>
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <input id="bookingaddressform-address" class="form-control" width="100%"
                       value="<?= $event->address->address ?>" disabled>
            </div>
            <div class="col-2">
                <input id="bookingaddressform-latitude" class="form-control" width="100%"
                       value="<?= $event->address->latitude ?>" disabled>
            </div>
            <div class="col-2">
                <input id="bookingaddressform-longitude" class="form-control" width="100%"
                       value="<?= $event->address->longitude ?>" disabled>
            </div>
        </div>
        <div class="row">
            <div id="map-view" style="width: 100%; height: 400px"></div>
        </div>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">SEO</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $event->meta,
            'attributes' => [
                [
                    'attribute' => 'title',
                    'label' => 'Заголовок',
                ],
                [
                    'attribute' => 'description',
                    'label' => 'Описание',
                ],
            ],
        ]) ?>
    </div>
</div>