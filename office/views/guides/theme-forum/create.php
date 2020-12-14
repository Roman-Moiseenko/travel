<?php

use booking\forms\forum\CategoryForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model CategoryForm */


$this->title = 'Создать тему форума';
$this->params['breadcrumbs'][] = ['label' => 'Темы Форума', 'url' => ['/guides/theme-forum']];
$this->params['breadcrumbs'][] = 'Создать';
?>
<div class="tour-type-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название темы') ?>
                </div>
                <div class="col-md-9">
                    <?= $form->field($model, 'description')->textarea()->label('Описание') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

