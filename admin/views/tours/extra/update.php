<?php

use booking\entities\booking\tours\Extra;
use booking\entities\booking\tours\Tours;
use booking\entities\Lang;
use booking\forms\booking\tours\ToursCommonForms;
use booking\helpers\ToursHelper;
use booking\helpers\ToursTypeHelper;
use kartik\widgets\FileInput;
//use mihaildev\ckeditor\CKEditor;
use shop\helpers\PriceHelper;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $tours Tours */
/* @var $searchModel admin\forms\tours\ExtraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $extra Extra */

$this->title = 'Изменить доп.услугу ' . $extra->name;
$this->params['id'] = $tours->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => 'Дополнительные услуги ' . $tours->name, 'url' => ['/tours/extra', 'id' => $tours->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tours-extra-view">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>


    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название услуги') ?>
                </div>
            </div>
            <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание')//->widget(CKEditor::class)   ?>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Цена</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form
                        ->field($model, 'cost')
                        ->textInput(['maxlength' => true])
                        ->label('Стоимость')
                        ->hint('Оставьте пустым, если бесплатная услуга') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

