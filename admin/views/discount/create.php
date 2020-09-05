<?php

use booking\helpers\DiscountHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Создать Промо-коды';
$this->params['breadcrumbs'][] = ['label' => 'Промо-коды', 'url' => ['/discount']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="discount-createe">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="card card-secondary">
        <div class="card-header with-border">Основные</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'entities')->dropDownList(DiscountHelper::listEntities(), ['prompt' => '', 'id' => 'discount-entities'])->label('Область скидок') ?>
                </div>
                <div class="col-8">
                    <?= $form->field($model, 'entities')->dropDownList([], ['id' => 'discount-entities-id'])->label('Объект скидок') ?>
                </div>

            </div>
            <div class="row">
                <div class="col">
            <?= $form->field($model, 'percent')->textInput(['maxlength' => true])->label('Скидка')//->widget(CKEditor::class)   ?>
                </div>
                <div class="col">
            <?= $form->field($model, 'count')->textInput(['maxlength' => true])->label('Кол-во применений')//->widget(CKEditor::class)   ?>
                </div>
                <div class="col">
            <?= $form->field($model, 'repeat')->textInput(['maxlength' => true])->label('Кол-во промо')//->widget(CKEditor::class)   ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

