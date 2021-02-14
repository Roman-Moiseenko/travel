<?php

use booking\entities\admin\Legal;
use booking\forms\booking\tours\StackTourForm;
use booking\helpers\AdminUserHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $model StackTourForm */
?>

<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'count')->textInput()->label('Количество')->hint('Кол-во экскурсий в сутки проводимых данным стеком') ?>
        <?= $form->field($model, 'name')->textInput()->label('Название стека') ?>
        <?= $form->field($model, 'legal_id')->dropdownList(AdminUserHelper::listLegals(), ['prompt' => ''])->label('Организация') ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
