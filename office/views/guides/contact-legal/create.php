<?php

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\forms\booking\tours\TourTypeForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model TourTypeForm */


$this->title = 'Создать контакт';
$this->params['breadcrumbs'][] = ['label' => 'Типы контактов', 'url' => ['/guides/contact-legal']];
$this->params['breadcrumbs'][] = 'Создать';
?>
<div class="tour-type-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model->photo, 'files')->label(false)->widget(FileInput::class, [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => false,
                        ],
                    ]) ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
                    <?= $form->field($model, 'type')->checkbox(['maxlength' => true])->label('Ссылка') ?>
                    <?= $form->field($model, 'prefix')->textInput(['maxlength' => true])->label('Префикс') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

