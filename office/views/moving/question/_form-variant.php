<?php


use booking\forms\survey\QuestionForm;
use booking\forms\survey\SurveyForm;
use booking\forms\survey\VariantForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model VariantForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card card-default">
        <div class="card-body">
            <?= $form->field($model, 'text')->textInput(['maxlength' => true])->label('Вариант ответа') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
