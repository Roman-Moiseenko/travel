<?php

use booking\entities\booking\cars\Car;
use booking\entities\booking\tours\Tour;
use booking\forms\booking\cars\CarParamsForm;
use booking\forms\booking\tours\TourParamsForm;
use booking\helpers\tours\TourHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model CarParamsForm */
/* @var $car Car */

$this->title = 'Редактировать Авто ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = ['label' => 'Параметры', 'url' => ['/car/params', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="car-params">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="card card-secondary">
        <div class="card-header with-border">Основные параметры</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'min_rent')->textInput(['min' => 1, 'type' => 'number'])->label('Минимальное бронирование (сут)') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'license')->dropDownList(Car::LICENSE, ['prompt' => ''])->label('Водительские права') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'experience')->textInput(['min' => 0, 'type' => 'number'])->label('Стаж') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'delivery')
                        ->checkbox()->label('Доставка до адреса')
                        ->hint('Если Вы предоставляете услугу доставки авто, добавьте дополнение "Доставка", с указанием цены или бесплатно, и опишите условия') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model->ageLimit, 'on')->checkbox()->label('Ограничение по возрасту') ?>
                </div>
                <div class="col-md-3 agelimit-edit" id="agelimitmin" style="display: none;">
                    <?= $form->field($model->ageLimit, 'ageMin')->textInput(['maxlength' => true, 'visible' => false])->label('Минимальный возраст') ?>
                </div>
                <div class="col-md-3 agelimit-edit" style="display: none;">
                    <?= $form->field($model->ageLimit, 'ageMax')->textInput(['maxlength' => true])->label('Максимальный возраст') ?>
                </div>
            </div>

        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Основные параметры</div>
        <div class="card-body">
            <?php foreach ($model->values as $i => $value): ?>
                <?php if ($variants = $value->variantsList()): ?>
                    <?= $form->field($value, '[' . $i . ']value')->dropDownList($variants, ['prompt' => '']) ?>
                <?php else: ?>
                    <?= $form->field($value, '[' . $i . ']value')->textInput() ?>
                <?php endif ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Точки выдачи/приема Авто</div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-8">
                            <div id="map-car" style="width: 100%; height: 400px"></div>
                        </div>
                        <div class="col-4">
                            <div id="map-points" data-count="<?= count($car->address) ?>">
                                <?php foreach ($car->address as $i => $address): ?>
                                    <div class="row">
                                        <div class="col-10">
                                            <input name="BookingAddressForm[<?= ($i + 1) ?>][address]"
                                                   class="form-control" width="100%" value="<?= $address->address ?>"
                                                   id="address-<?= ($i + 1) ?>"
                                                   readonly>
                                        </div>
                                        <div class="col-1">
                                            <?php if (count($car->address) == $i + 1): ?>
                                                <span class="glyphicon glyphicon-trash" style="cursor: pointer" id="remove-points"></span>
                                            <?php endif;?>
                                        </div>
                                        <div class="col-1">
                                            <input name="BookingAddressForm[<?= ($i + 1) ?>][longitude]"
                                                   class="form-control" width="100%" value="<?= $address->longitude ?>"
                                                   id="longitude-<?= ($i + 1) ?>"
                                                   type="hidden">
                                            <input name="BookingAddressForm[<?= ($i + 1) ?>][latitude]"
                                                   class="form-control" width="100%" value="<?= $address->latitude ?>"
                                                   id="latitude-<?= ($i + 1) ?>"
                                                   type="hidden">
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

