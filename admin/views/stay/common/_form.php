<?php

use booking\forms\booking\stays\StayCommonForm;
use booking\helpers\stays\StayTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
/* @var $model StayCommonForm */
/* @var $form ActiveForm */

?>

<div class="card card-secondary">

    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название жилья') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'type_id')->dropDownList(StayTypeHelper::list(), ['prompt' => ''])->label('Тип жилья') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название жилья (En)') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание')->widget(CKEditor::class, [
                    'editorOptions' => [
                        'preset' => 'basic', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    ],
                ])->hint('Краткий текст, особенности вашей квартиры. Основная информация о наличии удобств, спальных мест, ограничений и услуг будет введена в других разделах.') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'description_en')->textarea(['rows' => 6])->label('Описание (En)')->widget(CKEditor::class, [
                    'editorOptions' => [
                        'preset' => 'basic', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    ],
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <?= $form->field($model->address, 'address')->
                textInput(['maxlength' => true, 'style' => 'width:100%'])->label('Адрес') ?>
            </div>
            <div class="col-2">
                <?= $form->field($model->address, 'latitude')->textInput(['maxlength' => true, 'readOnly' => true])->label('Широта') ?>
            </div>
            <div class="col-2">
                <?= $form->field($model->address, 'longitude')->textInput(['maxlength' => true, 'readOnly' => true])->label('Долгота') ?>
            </div>
            <div class="col-8">
                <?= $form->field($model, 'city')->textInput(['maxlength' => true])->label('Город')->hint('Используется для поиска жилья по городу/нас.пункту') ?>
            </div>
        </div>
        <div class="row">
            <div id="map" style="width: 100%; height: 300px"></div>
        </div>
    </div>
</div>
