<?php


use booking\forms\survey\SurveyForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model SurveyForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-default">
        <div class="card-header with-border">Общие</div>
        <div class="card-body">
            <?= $form->field($model, 'caption')->textInput(['maxlength' => true])->label('Заголовок') ?>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header with-border">Для SEO</div>
        <div class="card-body">
            <?= $form->field($model->meta, 'title')->textInput()->label('Заголовок') ?>
            <?= $form->field($model->meta, 'description')->textarea(['rows' => 2])->label('Описание') ?>
            <?= $form->field($model->meta, 'keywords')->textInput()->label('Ключевые слова') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
