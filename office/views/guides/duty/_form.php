<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html; ?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Дополнительный сбор') ?>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
