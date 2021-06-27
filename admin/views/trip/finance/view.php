<?php

use booking\entities\admin\Legal;
use booking\entities\booking\trips\Trip;
use booking\helpers\BookingHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $trip Trip|null */

$this->title = 'Финансы ' . $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = 'Финансы';
?>
<p>
    <?= Html::a('Редактировать', Url::to(['trip/finance/update', 'id' => $trip->id]), ['class' => 'btn btn-success']) ?>
</p>
<div class="trip-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая стоимость</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $trip,
                'attributes' => [
                    [
                        'attribute' => 'cost_base',
                        'label' => 'Цена за тур',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Оплата</div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $trip,
                        'attributes' => [
                            [
                                'attribute' => 'legal_id',
                                'label' => 'Организация',
                                'value' => function () use ($trip) {
                                    $legal = Legal::findOne($trip->legal_id);
                                    return $legal ? $legal->name : '';
                                },
                            ],
                            [
                                'attribute' => 'cancellation',
                                'label' => 'Отмена брони',
                                'value' => BookingHelper::cancellation($trip->cancellation),
                            ],
                            [
                                'attribute' => 'prepay',
                                'label' => 'Предоплата (%)',
                                'value' => $trip->prepay,
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>