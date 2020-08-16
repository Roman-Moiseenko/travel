<?php

use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\ToursFinanceForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\ToursHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $tours Tour*/
/* @var $model ToursFinanceForm */


$this->title = 'Изменить оплату';
$this->params['id'] = $tours->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tours-view">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Базовая стоимость</div>
        <div class="card-body">
            <div class="col-md-6">
                <?= $form->field($model->baseCost, 'adult')->textInput(['maxlength' => true])->label('Билет для взрослых') ?>
            </div>
                <div class="col-md-6">
                <?= $form->field($model->baseCost, 'child')->textInput(['maxlength' => true])->label('Билет для детей') ?>
                </div>
                    <div class="col-md-6">
                <?= $form->field($model->baseCost, 'preference')->textInput(['maxlength' => true])->label('Билет для льготных граждан') ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Оплата</div>
                <div class="card-body">
                    <div class="col-md-9">
                        <?= $form->field($model, 'legal_id')->dropDownList(AdminUserHelper::listLegals(), ['prompt' => ''])->label('Организация') ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'cancellation')
                            ->textInput(['maxlength' => true])->label('Отмена бронирования')
                            ->hint('Оставьте пустым, если отмена не предусмотрена, 0 - если в любой день или укажите кол-во дней, за сколько можно отменить бронирование.') ?>
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

