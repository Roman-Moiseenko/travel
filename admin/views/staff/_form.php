<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$js = <<<JS
$(document).on('click', '#generate-password', function() {
  $.post('/staff/get-password', {}, function(data) {
    $('#userform-password').val(data);
  })
});
JS;
$this->registerJs($js);

?>



<div class="card">
    <div class="card-body">
        <div class="user-form">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'username')->textInput()->label('Логин') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'password')->textInput()->label('Пароль') ?>
                </div>
                <div class="col-sm-6 d-flex">
                    <div></div>
                    <div class="mt-auto mb-3"><a class="btn btn-info" id="generate-password">Сгенерировать пароль</a></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <?= $form->field($model, 'fullname')->textInput()->label('ФИО') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <?= $form->field($model, 'box_office')->textInput()->label('Касса/Точка продаж') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'phone')->textInput()->label('Телефон') ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
