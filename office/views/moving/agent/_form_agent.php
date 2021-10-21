<?php

use booking\entities\moving\agent\Agent;
use booking\forms\moving\AgentForm;
use kartik\widgets\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


/* @var $this View */
/* @var $model AgentForm */
/* @var $agent Agent|null */

?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'region_id')->textInput(['type' => 'hidden'])->label(false) ?>

<div class="card card-secondary">
    <div class="card-header with-border">Общие</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model->person, 'surname')->textInput(['maxlength' => true])->label('Фамилия') ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model->person, 'firstname')->textInput(['maxlength' => true])->label('Имя') ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model->person, 'secondname')->textInput(['maxlength' => true])->label('Отчество') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Email') ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label('Телефон') ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'type')->dropDownList(Agent::ARRAY_TYPES)->label('Тип') ?>
            </div>
        </div>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Описание</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-9">
                <?= $form->field($model, 'description')->textarea(['rows' => 6])->label(false)->widget(CKEditor::class) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model->photo, 'files')->label(false)->widget(FileInput::class, [
                    'language' => 'ru',
                    'bsVersion' => '4.x',
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'initialPreview' => [
                            $agent ? $agent->getThumbFileUrl('photo', 'profile') : false,
                        ],
                        'initialPreviewAsData' => true,
                        'overwriteInitial' => true,
                        'showRemove' => false,
                    ],
                ]) ?>
            </div>
        </div>
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
            <div id="map" style="width: 100%; height: 400px" data-restrict="no"></div>
        </div>
    </div>
</div>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
