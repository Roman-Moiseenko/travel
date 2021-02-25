<?php

use booking\entities\booking\stays\Stay;
use booking\entities\booking\stays\StayParams;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $stay Stay */

$this->title = 'Дополнительные сборы ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Мое жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Дополнительные сборы';

?>

<div class="params-stay">
    <div class="card card-info">
        <div class="card-header">Дополнительные сборы</div>
        <div class="card-body">

        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['update', 'id' => $stay->id]), ['class' => 'btn btn-success']) ?>
    </div>
</div>