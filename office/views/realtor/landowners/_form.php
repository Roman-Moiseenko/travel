<?php


use booking\forms\realtor\LandownerForm;
use mihaildev\elfinder\ElFinder;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model LandownerForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="landowner-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-secondary">
        <div class="card-header with-border">Общие</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <?= $form->field($model, 'name')->textInput()->label('Название Землевладения') ?>
                </div>
                <div class="col-4">
                    <?= $form->field($model, 'slug')
                        ->textInput(['maxlength' => true])
                        ->label('Ссылка')
                        ->hint('Оставьте пустым, заполнится автоматически') ?>
                </div>
                <div class="col-4">
                    <?= $form->field($model, 'title')->textInput()->label('Заголовок H1') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Сведения о землевладельце</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <?= $form->field($model, 'caption')->textInput()->label('ФИО или Организация') ?>
                </div>
                <div class="col-4">
                    <?= $form->field($model, 'email')->textInput()->label('Почта') ?>
                </div>
                <div class="col-4">
                    <?= $form->field($model, 'phone')->textInput()->label('Телефон') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-secondary">
        <div class="card-header with-border">Предварительно Описание</div>
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <?= $form->field($model, 'cost')->textInput()->label('Цена за сотку (от ...)') ?>
                </div>
                <div class="col-3">
                    <?= $form->field($model, 'size')->textInput()->label('Размер участка (от ... ст)') ?>
                </div>
                <div class="col-3">
                    <?= $form->field($model, 'count')->textInput()->label('Кол-во участков') ?>
                </div>
                <div class="col-3">
                    <?= $form->field($model, 'distance')->textInput()->label('До Калининграда (км)') ?>
                </div>
            </div>
            <?= $form->field($model, 'description')->textarea(['row' => 20])->label('Краткое описание') ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Подробное</div>
        <div class="card-body">
            <?= $form->field($model, 'text')->widget(CKEditor::class)->label('Содержимое')/**/ ?>
        </div>
    </div>

    <div class="card card-secondary">
        <div class="card-header">Карта</div>
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
                <div id="map" style="width: 100%; height: 600px"></div>
            </div>
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
