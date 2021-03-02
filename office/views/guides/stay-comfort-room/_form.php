<?php

use booking\helpers\stays\ComfortHelper;
use booking\helpers\stays\ComfortRoomHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html; ?>

<div class="comfort-category-create">

    <?php $form = ActiveForm::begin([]); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'category_id')->dropdownList(ComfortRoomHelper::listCategories(), ['prompt' => ''])->label('Категория') ?>
                </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'photo')->checkbox(['maxlength' => true])->label('Возможнось загрузки фото') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'featured')->checkbox(['maxlength' => true])->label('Рекомендуемый') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
