<?php

use booking\entities\booking\trips\Trip;
use booking\helpers\CurrencyHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $trip Trip|null */
$this->title = 'Параметры ' . $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = 'Параметры';

?>

<p>
    <?= Html::a('Редактировать', Url::to(['trip/params/update', 'id' => $trip->id]), ['class' => 'btn btn-success']) ?>
</p>
<div class="card card-secondary">
    <div class="card-header with-border">Параметры</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $trip,
            'attributes' => [
                [
                    'attribute' => 'params.duration',
                    'label' => 'Длительность тура (ночей)',
                ],
                [
                    'attribute' => 'params.transfer',
                    'value' => $trip->params->transfer === null ? 'Не предоставяется' : CurrencyHelper::get($trip->params->transfer),
                    'format' => 'raw',
                    'label' => 'Трансфер',
                ],
                [
                    'attribute' => 'params.capacity',
                    'label' => 'Вместительность тура (человек)',
                ],
            ],
        ]) ?>

    </div>
</div>
