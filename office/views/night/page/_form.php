<?php


use booking\entities\night\Page;
use kartik\widgets\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model booking\forms\night\PageForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $page Page */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-default">
        <div class="card-header with-border">Общие</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
            <?= $form->field($model, 'parentId')->dropDownList($model->parentsList())->label('Родительская страница')?>
            <?= $form->field($model, 'icon')->textInput(['maxlength' => true])->label('Иконка') ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название')->hint('Подпись на ссылки') ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Заголовок')->hint('Заголовок H1') ?>
            <?= $form->field($model, 'slug')
                ->textInput(['maxlength' => true])
                ->label('Ссылка')
                ->hint('Оставьте пустым, заполнится автоматически') ?>
                </div>
                <div class="col-sm-6" style="text-align: center">

                        <?= $form->field($model->photo, 'files')->label(false)->widget(FileInput::class, [
                            'language' => 'ru',
                            'options' => [
                                'accept' => 'image/*',
                                'multiple' => false,
                            ],
                            'pluginOptions' => [
                                'initialPreview' => [
                                    $page ? $page->getThumbFileUrl('photo', 'admin') : null,
                                ],
                                'initialPreviewAsData' => true,
                                'overwriteInitial' => true,
                                'showRemove' => false,
                            ],
                        ]) ?>

                </div>
            </div>
            <?= $form->field($model, 'description')->widget(CKEditor::class)->label('Описание') ?>
            <?= $form->field($model, 'content')->widget(CKEditor::class)->label('Текст') ?>

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
