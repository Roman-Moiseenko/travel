<?php

use booking\helpers\cars\CarTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html; ?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card card-secondary">
            <div class="card-header with-border">Категория</div>
            <div class="card-body">
                <?= $form->field($model, 'type_id')->dropDownList(CarTypeHelper::list(), ['prompt' => ''])->label(false) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card card-secondary">
            <div class="card-header with-border">Расположение</div>
            <div class="card-body">
                <label>Укажите города, в которых расположены Ваши пункты проката или до куда вы осуществляете доставку</label>
                <?= $form->field($model->cities, 'cities')
                    ->checkboxList($model->cities->list())->label(false)
                    ->hint('При незаполнении данного атрибута, Ваше авто не попадет в список при поиске по городам') ?>
            </div>
        </div>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название авто (Модель и т.п.)') ?>
            </div>
            <div class="col-md-1">
                <?= $form->field($model, 'year')->textInput(['maxlength' => true])->label('Год выпуска') ?>
            </div>
        </div>
        <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание')->widget(CKEditor::class)->hint('Напишите красочный текст, желательно не менее 40-50 слов для привлечение клиентов и для более высокого ранжирования Вашего авто') ?>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Основные EN</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название авто (En)') ?>
            </div>
        </div>
        <?= $form->field($model, 'description_en')->textarea(['rows' => 6])->label('Описание (En)')->widget(CKEditor::class) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
