<?php


use booking\forms\survey\QuestionForm;
use booking\forms\survey\SurveyForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model QuestionForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card card-default">
        <div class="card-header with-border">Общие</div>
        <div class="card-body">
            <?= $form->field($model, 'question')->textInput(['maxlength' => true])->label('Вопрос') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
