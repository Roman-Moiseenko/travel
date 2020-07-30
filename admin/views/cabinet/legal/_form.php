<?php

use booking\forms\auth\UserLegalForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model UserLegalForm*/
?>


<?php $form = ActiveForm::begin(); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Организация</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Наименование') ?>
                    <?= $form->field($model, 'INN')->textInput(['maxlength' => true])->label('ИНН') ?>
                    <?= $form->field($model, 'KPP')->textInput(['maxlength' => true])->label('КПП') ?>
                    <?= $form->field($model, 'OGRN')->textInput(['maxlength' => true])->label('ОГРН') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-secondary">
        <div class="card-header with-border">Реквизиты для оплаты</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'BIK')->textInput(['maxlength' => true])->label('БИК банка') ?>
                    <?= $form->field($model, 'account')->textInput(['maxlength' => true])->label('Р/счет') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>