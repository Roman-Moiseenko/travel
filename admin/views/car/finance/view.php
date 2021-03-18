<?php

use booking\entities\admin\Legal;
use booking\entities\booking\cars\Car;
use booking\helpers\BookingHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $car Car */


$this->title = 'Цены для ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Цены';
?>
<div class="cars-view">
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая стоимость</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $car,
                'attributes' => [
                    [
                        'attribute' => 'cost',
                        'label' => 'Цена проката в сутки',
                    ],
                    [
                        'attribute' => 'deposit',
                        'label' => 'Залог',
                    ],
                    [
                        'attribute' => 'quantity',
                        'label' => 'Кол-во средств данной модели',
                    ],
                    [
                        'attribute' => 'discount_of_days',
                        'value' => $car->discount_of_days ? $car->discount_of_days . ' %' : 'нет',
                        'label' => 'Скидка при прокате более 3 дней',
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Оплата</div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $car,
                        'attributes' => [
                            [
                                'attribute' => 'legal_id',
                                'label' => 'Организация',
                                'value' => function () use ($car) {
                                    $legal = Legal::findOne($car->legal_id);
                                    return $legal ? $legal->name : '';
                                },
                            ],
                            [
                                'attribute' => 'cancellation',
                                'label' => 'Отмена брони',
                                'value' => BookingHelper::cancellation($car->cancellation),
                            ],
                            [
                                'attribute' => 'prepay',
                                'label' => 'Предоплата (%)',
                                'value' => $car->prepay,
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/car/finance/update', 'id' => $car->id]), ['class' => 'btn btn-success']) ?>
    </div>

</div>

