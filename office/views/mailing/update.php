<?php

use booking\entities\mailing\Mailing;
use booking\entities\office\User;
use booking\helpers\OfficeUserHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Mailing */

$this->title = 'Изменить рассылку';
$this->params['breadcrumbs'][] = ['label' => 'Рассылка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <div class="card">
        <div class="card-body">
            <div class="user-form">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'theme')->dropDownList(Mailing::listTheme(), ['prompt' => ''])->label('Тема') ?>
                <?= $form->field($model, 'subject')->widget(CKEditor::class)->label('Сообщение') ?>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
