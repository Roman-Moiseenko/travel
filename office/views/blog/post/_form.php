<?php

use booking\entities\blog\post\Post;
use booking\forms\blog\post\PostForm;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model PostForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить и Выйти', ['class' => 'btn btn-success',
            'data-method' => 'POST',
            'data-params' => [
                'close' => true,
            ],
        ]) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info']) ?>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header with-border">Общие</div>
                <div class="card-body">
                    <?= $form->field($model, 'categoryId')->dropDownList($model->categoriesList(), ['prompt' => ''])->label('Категория') ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header with-border">Метки</div>
                <div class="card-body">
                    <?= $form->field($model->tags, 'existing')->checkboxList($model->tags->tagsList())->label('Выбрать') ?>
                    <?= $form->field($model->tags, 'textNew')->textInput()->label('Добавить новые') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">Описание</div>
        <div class="card-body">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Заголовок') ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 5])->label('Описание') ?>
            <?= $form->field($model, 'content')->widget(CKEditor::class)->label('Содержимое')/**/ ?>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">Описание EN</div>
        <div class="card-body">
            <?= $form->field($model, 'title_en')->textInput(['maxlength' => true])->label('Заголовок (En)') ?>
            <?= $form->field($model, 'description_en')->textarea(['rows' => 5])->label('Описание (En)') ?>
            <?= $form->field($model, 'content_en')->widget(CKEditor::class)->label('Содержимое (En)')/**/ ?>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header with-border">Картинка</div>
        <div class="card-body">
            <?= $form->field($model, 'photo')->label(false)->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false,

                ],
                'pluginOptions' => [
                    'initialPreview' => [
                        ($model->_post) ? $model->_post->getThumbFileUrl('photo', 'profile'): null, //$user->personal->getThumbFileUrl('photo', 'profile'),
                    ],
                    'initialPreviewAsData' => true,
                    'overwriteInitial' => true,
                    'showRemove' => false,
                ],
            ]) ?>
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
        <?= Html::submitButton('Сохранить и Выйти', ['class' => 'btn btn-success',
            'data-method' => 'POST',
            'data-params' => [
                'close' => true,
            ],
        ]) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
