<?php

use booking\entities\booking\tours\Tour;
use booking\helpers\BookingHelper;
use booking\helpers\tours\TourHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $tour Tour*/


$this->title = 'Параметры ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Параметры';
?>
<div class="tours-view">

    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Основные параметры</div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $tour,
                        'attributes' => [
                            [
                                'attribute' => 'params.duration',
                                'label' => 'Длительность (ч мин)',
                            ],
                            [
                                'attribute' => 'params.private',
                                'value' => TourHelper::stringPrivate($tour->params->private),
                                'label' => 'Групповой/Индивидуальный',
                            ],
                            [
                                'attribute' => 'params.groupMin',
                                'label' => 'Минимальное кол-во в группе',
                            ],
                            [
                                'attribute' => 'params.groupMax',
                                'label' => 'Максимальное кол-во в группе',
                            ],
                            [
                                'label' => 'Ограничение по возрасту',
                                'value' => function (Tour $model) {
                                    return BookingHelper::ageLimit($model->params->agelimit);
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
                <div class="card-header with-border">Точка сбора</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <input id="bookingaddressform-address" class="form-control" width="100%" value="<?= $tour->params->beginAddress->address ?? ' ' ?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude" class="form-control" width="100%" value="<?= $tour->params->beginAddress->latitude ?? '' ?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude" class="form-control" width="100%" value="<?= $tour->params->beginAddress->longitude ?? '' ?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div id="map-view" style="width: 100%; height: 200px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Точка окончания</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <input id="bookingaddressform-address-2" class="form-control" width="100%" value="<?= $tour->params->endAddress->address ?? ' ' ?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude-2" class="form-control" width="100%" value="<?= $tour->params->endAddress->latitude ?? '' ?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude-2" class="form-control" width="100%" value="<?= $tour->params->endAddress->longitude ?? '' ?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div id="map-view-2" style="width: 100%; height: 200px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/tour/params/update', 'id' => $tour->id]) ,['class' => 'btn btn-success']) ?>
    </div>
    

</div>

