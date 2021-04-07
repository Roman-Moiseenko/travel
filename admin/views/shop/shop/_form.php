<?php


use booking\forms\booking\tours\TourCommonForm;
use booking\helpers\AdminUserHelper;
use booking\helpers\shops\ShopTypeHelper;
use booking\helpers\tours\TourTypeHelper;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model TourCommonForm */


?>

<div class="card card-secondary">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название магазина') ?>
            </div>
        </div>
        <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание') ?>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Основные EN</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название магазина (En)') ?>
            </div>
        </div>
        <?= $form->field($model, 'description_en')->textarea(['rows' => 6])->label('Описание (En)') ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-secondary">
            <div class="card-header with-border">Дополнительно</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model->types, 'type_id')->dropDownList(ShopTypeHelper::list(), ['prompt' => ''])->label('Тип') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'legal_id')->dropDownList(AdminUserHelper::listLegals(), ['prompt' => ''])->label('Организация'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

