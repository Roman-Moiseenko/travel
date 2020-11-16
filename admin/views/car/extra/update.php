<?php

use booking\entities\booking\cars\Car;
use booking\entities\booking\tours\Extra;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $car Car */
/* @var $searchModel admin\forms\cars\ExtraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $extra Extra */

$this->title = 'Изменить доп.услугу ' . $extra->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = ['label' => 'Дополнительные услуги', 'url' => ['/car/extra', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="tours-extra-view">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>


    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название услуги') ?>
                </div>
            </div>
            <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание')//->widget(CKEditor::class)   ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Основные EN</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название услуги (En)') ?>
                </div>
            </div>
            <?= $form->field($model, 'description_en')->textarea(['rows' => 6])->label('Описание (En)')//->widget(CKEditor::class)   ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Цена</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form
                        ->field($model, 'cost')
                        ->textInput(['maxlength' => true])
                        ->label('Стоимость')
                        ->hint('Оставьте пустым, если бесплатная услуга') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

