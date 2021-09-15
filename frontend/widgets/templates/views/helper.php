<?php

/* @var $title string */
/* @var $youtube string */

/* @var $link string */

use lesha724\youtubewidget\Youtube; ?>

<h2 class="pt-5"><?= $title ?></h2>

<div class="row pt-4">
    <div class="col-sm-12">
        <span style="font-size: 14px; color: #560000">Пока готовится к выпуску видео ряд, Вы можете ознакомиться с текстовой версией, снабженной поясняющими иллюстрациями -</span>
        <?='' /*Youtube::widget([

                'class' => 'youtube-video'
            ],
            'divOptions' => [
                'class' => 'youtube-video-div'
            ],
            //'height'=> '100%',
            'width' => '100%',
            'playerVars' => [
                'controls' => 1,
                'autoplay' => 0,
                'showinfo' => 0,
                'start' => 0,
                'end' => 0,
                'loop ' => 0,
                'modestbranding' => 1,
                'fs' => 1,
                'rel' => 0,
                'disablekb' => 0
            ],
            'events' => [
                'onReady' => 'function (event){
                        //event.target.playVideo();
            }',
            ]
        ]); */?>
    </div>
</div>
<a class="pt-4" href="<?= $link ?>" target="_blank" style="font-size: 14px">Текстовая версия видеоинструкции "Как заказать экскурсию"</a>
