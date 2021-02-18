<?php

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\forms\office\guides\TourTypeForm;
use booking\forms\office\guides\TypeOfBedForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model TypeOfBedForm */


$this->title = 'Редактировать Тип';
$this->params['breadcrumbs'][] = ['label' => 'Типы кроватей', 'url' => ['/guides/tour-of-bed']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="tour-type-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'count')->textInput(['maxlength' => true])->label('Кол-во мест') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

