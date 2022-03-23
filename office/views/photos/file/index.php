<?php

/* @var $this yii\web\View */

use mihaildev\elfinder\ElFinder;

$this->title = 'Файлы для фотоблога';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">

    <?= ElFinder::widget([
        'language'         => 'ru',
        'controller'       => 'elfinder_photo',
        //'path' => 'images/photos/',
        'frameOptions' => ['style' => 'width: 100%; height: 640px; border: 0;']
    ]); ?>

</div>