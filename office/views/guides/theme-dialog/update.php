<?php

use booking\entities\booking\tours\Tour;
use booking\entities\booking\tours\Type;
use booking\entities\message\ThemeDialog;
use booking\forms\office\guides\ThemeDialogForm;
use booking\helpers\DialogHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var  $model ThemeDialogForm */


$this->title = 'Редактировать тему';
$this->params['breadcrumbs'][] = ['label' => 'Темы диалогов', 'url' => ['/guides/theme-dialog']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="tour-type-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'caption')->textInput(['maxlength' => true])->label('Заголовок темы') ?>
                    <?= $form->field($model, 'type_dialog')->dropDownList(DialogHelper::getTypeList(), ['prompt' => ''])->label('Тип диалога') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

