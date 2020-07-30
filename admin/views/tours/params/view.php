<?php

use booking\entities\booking\tours\Tours;
use booking\helpers\ToursHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $tours Tours*/


$this->title = 'Параметры тура ' . $tours->name;
$this->params['id'] = $tours->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tours-view">

    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Основные параметры</div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $tours,
                        'attributes' => [
                            [
                                'attribute' => 'params.duration',
                                'label' => 'Длительность (ч мин)',
                            ],
                            [
                                'attribute' => 'params.private',
                                'value' => ToursHelper::stringPrivate($tours->params->private),
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
                                'value' => function (Tours $model) {
                                    return ToursHelper::ageLimit($model->params->agelimit);
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
                            <input id="bookingaddressform-address" class="form-control" width="100%" value="<?= $tours->params->beginAddress->address ?? ' ' ?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude" class="form-control" width="100%" value="<?= $tours->params->beginAddress->latitude ?? '' ?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude" class="form-control" width="100%" value="<?= $tours->params->beginAddress->longitude ?? '' ?>" disabled>
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
                            <input id="bookingaddressform-address-2" class="form-control" width="100%" value="<?= $tours->params->endAddress->address ?? ' ' ?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude-2" class="form-control" width="100%" value="<?= $tours->params->endAddress->latitude ?? '' ?>" disabled>
                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude-2" class="form-control" width="100%" value="<?= $tours->params->endAddress->longitude ?? '' ?>" disabled>
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
        <?= Html::a('Редактировать', Url::to(['/tours/params/update', 'id' => $tours->id]) ,['class' => 'btn btn-success']) ?>
    </div>
    

</div>

