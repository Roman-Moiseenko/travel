<?php

use booking\forms\blog\map\MapsForm;

/* @var $this yii\web\View */
/* @var $model MapsForm */

$this->title = 'Создать Карту';
$this->params['breadcrumbs'][] = ['label' => 'Карты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
