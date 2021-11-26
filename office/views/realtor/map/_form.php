<?php

use booking\entities\realtor\land\Land;
use booking\forms\land\LandForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model LandForm */
/* @var $land Land */
?>

<?php $form = ActiveForm::begin([]); ?>
<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-9">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название участка') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'min_price')->textInput(['maxlength' => true])->label('Мин.цена за 1га') ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'count')->textInput(['maxlength' => true])->label('Кол-во участков') ?>
                </div>
                <div class="col-sm-4">
                    <div class="form-group p-2">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                        <button type="button" id="get-points">Тест</button>
                    </div>
                </div>
        </div>
    </div>
    <div id="map-land-edit" style="width: 100%; height: 700px;"></div>
    <div id="points">
        <?= $form->field($model->points[0], '[0]latitude')->textInput(['maxlength' => true])->label('latitude') ?>
        <?= $form->field($model->points[0], '[0]longitude')->textInput(['maxlength' => true])->label('longitude') ?>

        <?php if ($land): ?>

        <?php endif; ?>
    </div>
</div>
    <div class="form-group p-2">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
