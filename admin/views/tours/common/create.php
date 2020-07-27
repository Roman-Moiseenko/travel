<?php

use booking\forms\booking\tours\ToursCommonForms;
use booking\helpers\ToursTypeHelper;
use kartik\widgets\FileInput;
//use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ToursCommonForms */

$this->title = 'Создать Тур';
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="box box-default">
        <div class="box-header with-border"></div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название тура') ?>
                </div>
            </div>
            <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание')//->widget(CKEditor::class)   ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">Расположение</div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-8">
                        <?= $form->field($model->address, 'address')->
                        textInput(['maxlength' => true, 'style' => 'width:100%'])->label(false) ?>
                        </div>
                        <div class="col-2">
                            <?= $form->field($model->address, 'latitude')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                        <div class="col-2">
                            <?= $form->field($model->address, 'longitude')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div id="map" style="width: 100%; height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">Категории</div>
                <div class="box-body">
                    <?= $form->field($model->types, 'main')->dropDownList(ToursTypeHelper::list(), ['prompt' => ''])->label('Основная') ?>
                    <?= $form->field($model->types, 'others')->checkboxList(ToursTypeHelper::list())->label('Дополнительно') ?>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

