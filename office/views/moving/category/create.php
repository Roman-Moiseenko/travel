<?php

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\forms\booking\tours\TourTypeForm;
use booking\forms\moving\CategoryFAQForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model CategoryFAQForm */


$this->title = 'Создать категорию вопросов';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['/movies/category']];
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
                    <?= $form->field($model, 'caption')->textInput(['maxlength' => true])->label('Заголовок') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'description')->textarea([])->label('Описание') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

