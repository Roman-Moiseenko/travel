<?php

use booking\forms\booking\funs\FunCommonForm;
use booking\helpers\funs\FunTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model FunCommonForm */

$this->title = 'Создать Развлечение';
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название Развлечения') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'type_id')->dropDownList(FunTypeHelper::list(), ['prompt' => ''])->label('Категория') ?>
                </div>
            </div>
            <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание')->widget(CKEditor::class) ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Основные EN</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название Развлечения (En)') ?>
                </div>
            </div>
            <?= $form->field($model, 'description_en')->textarea(['rows' => 6])->label('Описание (En)')->widget(CKEditor::class) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Далее >>', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

