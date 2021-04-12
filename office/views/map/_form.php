<?php


use booking\forms\blog\map\MapsForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model MapsForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="map-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Заголовок') ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->label('Ссылка') ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
