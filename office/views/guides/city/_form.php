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
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Город') ?>
                <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Город (En)') ?>
                <?= $form->field($model, 'latitude')
                    ->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'bookingaddressform-latitude'])
                    ->label('Координаты (широта)') ?>
                <?= $form->field($model, 'longitude')
                    ->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'bookingaddressform-longitude'])
                    ->label('Координаты (долгота)') ?>
            </div>
        </div>
        <div class="row">
            <input type="hidden" id="bookingaddressform-address" value="">
            <div id="map" style="width: 100%; height: 400px">
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
