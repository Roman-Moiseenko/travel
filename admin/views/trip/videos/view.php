<?php

use booking\entities\booking\trips\Trip;
use lesha724\youtubewidget\Youtube;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $trip Trip|null */

$this->title = 'Видеообзоры ' . $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = 'Видео';

?>

<div>
<p>
    <?= Html::a('Добавить видеофайл', Url::to(['trip/videos/create', 'id' => $trip->id]), ['class' => 'btn btn-success']) ?>
</p>
    <div class="card card-secondary" id="photos">
        <div class="card-header with-border">Видео</div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($trip->videos as $video): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-video-up', 'id' => $trip->id, 'video_id' => $video->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-video', 'id' => $trip->id, 'video_id' => $video->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                                'data-confirm' => 'Remove video?',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update-video', 'id' => $trip->id, 'video_id' => $video->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-video-down', 'id' => $trip->id, 'video_id' => $video->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                        </div>
                        <div>
                            <?= Youtube::widget([
                                'video'=> $video->url,
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
                        <div>
                            <?= $video->caption ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
