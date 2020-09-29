<?php

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\forms\office\guides\TourTypeForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model TourTypeForm */


$this->title = 'Редактировать категорию тура';
$this->params['breadcrumbs'][] = ['label' => 'Категории туров', 'url' => ['/guides/tour-type']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="tour-type-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
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

