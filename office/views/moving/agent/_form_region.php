<?php

use booking\forms\moving\RegionForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


/* @var $this View */
/* @var $model RegionForm */
?>
<?php $form = ActiveForm::begin(); ?>

<div class="card card-default">
    <div class="card-header with-border">Общие</div>
    <div class="card-body">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
        <?= $form->field($model, 'link')->textInput(['maxlength' => true])->label('Ссылка на форум') ?>
    </div>
</div>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
