<?php

use booking\entities\booking\cars\Car;

use booking\helpers\BookingHelper;
use booking\helpers\StatusHelper;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $car Car*/


$this->title = 'Параметры ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Параметры';
?>
<div class="tours-view">

    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Основные параметры</div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $car,
                        'attributes' => [
                            [
                                'attribute' => 'params.min_rent',
                                'label' => 'Минимальное бронирование (сут)',
                            ],
                            [
                                'attribute' => 'params.license',
                                'label' => 'Водительские права',
                            ],
                            [
                                'attribute' => 'params.experience',
                                'label' => 'Стаж',
                            ],
                            [
                                'attribute' => 'params.delivery',
                                'value' => StatusHelper::yes_no($car->params->delivery, ['no' => 'warning']),
                                'format' => 'raw',
                                'label' => 'Доставка до адреса',
                            ],
                            [
                                'label' => 'Ограничение по возрасту',
                                'value' => function (Car $model) {
                                    return BookingHelper::ageLimit($model->params->age);
                                },
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Характеристики Авто</div>
                <div class="card-body">
                    <table class="table table-adaptive table-striped table-bordered">

                        <tbody>
                    <?php foreach ($car->values as $value): ?>
                    <tr>
                        <td data-label="Характеристика"><?= $value->characteristic->name ?></td>
                        <td data-label="Значение"><?= $value->value ?></td>
                    </tr>
                    <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Точки выдачи/приема Авто</div>
                <div class="card-body">
                    <div id="count-points" data-count="<?= count($car->address)?>">
                        <?php foreach ($car->address as $i => $address): ?>
                            <input type="hidden" id="address-<?= ($i+1)?>" value="<?= $address->address?>">
                            <input type="hidden" id="latitude-<?= ($i+1)?>" value="<?= $address->latitude?>">
                            <input type="hidden" id="longitude-<?= ($i+1)?>" value="<?= $address->longitude?>">
                        <?php endforeach;?>
                    </div>
                    <div class="row">
                        <div id="map-car-view" style="width: 100%; height: 200px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/car/params/update', 'id' => $car->id]) ,['class' => 'btn btn-success']) ?>
    </div>
    

</div>

