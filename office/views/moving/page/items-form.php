<?php

use booking\entities\moving\Item;
use kartik\widgets\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $item Item */
?>

<div class="item-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-secondary">
        <div class="card-header with-border">Общие</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Заголовок') ?>
                </div>
                <div class="col-3">
                <?= $form->field($model, 'page_id')->textInput(['maxlength' => true])->label('ID поста на форуме') ?>
                </div>
            </div>
            <?= $form->field($model, 'text')->widget(CKEditor::class)->label('Текст') ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Фото</div>
        <div class="card-body">
            <label>Прежде, чем удалять или смещать позицию фотографий, сохраните внесенные изменения!</label>
            <?php if ($item): ?>
                <div class="row">
                    <?php foreach ($item->photos as $photo): ?>
                        <div class="col-md-2 col-xs-3" style="text-align: center">
                            <div class="btn-group">
                                <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['item-delete-photo', 'id' => $page->id, 'item_id' => $item->id, 'photo_id' => $photo->id], [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Remove photo?',
                                ]); ?>
                            </div>
                            <div>
                                <?= Html::a(
                                    Html::img($photo->getThumbFileUrl('file', 'thumb')),
                                    $photo->getUploadedFileUrl('file'),
                                    ['class' => 'thumbnail', 'target' => '_blank']
                                ) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif ?>

            <?= $form->field($model->photos, 'files[]')
                ->label(false)
                ->widget(FileInput::class, [
                    'language' => 'ru',
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['jpg', 'jpeg'],
                    ],
                ]) ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Расположение</div>
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <?= $form->field($model->address, 'address')->
                    textInput(['maxlength' => true, 'style' => 'width:100%'])->label(false) ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model->address, 'latitude')->textInput(['maxlength' => true, 'readOnly' => true])->label(false) ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model->address, 'longitude')->textInput(['maxlength' => true, 'readOnly' => true])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div id="map" style="width: 100%; height: 400px"></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>