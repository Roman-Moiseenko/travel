<?php


use booking\forms\admin\UserEditForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $model UserEditForm */


$this->title = 'Изменить';
$this->params['breadcrumbs'][] = ['label' => 'Аутентификация', 'url' => ['/cabinet/auth']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-update">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Входные данные</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'username')->textInput()->label('логин'); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'email')->textInput()->label('email'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
