<?php

use booking\forms\blog\TagForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model TagForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-default">
        <div class="card-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Тег') ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Оставьте пустым, заполняется автоматически') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
