<?php



/* @var $this \yii\web\View */
/* @var $title string */
/* @var $label string */
/* @var $footer string */

use yii\bootstrap4\Modal; ?>

<?php Modal::begin([
    'title' => [
        'toggleButton' => ['label' => 'click me'],
    ]
]) ?>

<div class="card">
    <div class="card">
        Текст Фото и  Ссылки
    </div>
</div>

<?php Modal::end() ?>