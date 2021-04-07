<?php

use booking\forms\office\guides\MaterialForm;
use booking\forms\office\guides\ShopTypeForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model MaterialForm */


$this->title = 'Создать материал';
$this->params['breadcrumbs'][] = ['label' => 'Материалы', 'url' => ['/guides/material']];
$this->params['breadcrumbs'][] = 'Создать';
?>
<div class="shop-type-create">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название категории') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

