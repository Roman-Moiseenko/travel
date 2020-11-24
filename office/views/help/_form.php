<?php


use mihaildev\elfinder\ElFinder;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model booking\forms\HelpForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-default">
        <div class="card-header with-border">Общие</div>
        <div class="card-body">
            <?= $form->field($model, 'parentId')->dropDownList($model->parentsList())->label('Родительская страница')?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Заголовок') ?>
            <?= $form->field($model, 'icon')->textInput(['maxlength' => true])->label('Иконка (fas fa-...)') ?>
            <?= $form->field($model, 'slug')
                ->textInput(['maxlength' => true])
                ->label('Ссылка')
                ->hint('Оставьте пустым, заполнится автоматически') ?>
            <?= $form->field($model, 'content')->widget(CKEditor::class)->label('Текст') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
