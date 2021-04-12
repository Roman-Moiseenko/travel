<?php

use booking\entities\blog\map\Maps;
use booking\forms\blog\map\MapsForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $map Maps*/
/* @var $model MapsForm */

$this->title = 'Редактировать Карту: ' . $map->name;
$this->params['breadcrumbs'][] = ['label' => 'Карты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $map->name, 'url' => ['view', 'id' => $map->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="page-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
