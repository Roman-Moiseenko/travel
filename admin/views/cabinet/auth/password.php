<?php


use booking\forms\admin\PasswordEditForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $model PasswordEditForm */


$this->title = 'Изменить Пароль';
$this->params['breadcrumbs'][] = ['label' => 'Аутентификация', 'url' => ['/cabinet/auth']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-update">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <div class="card card-secondary">
        <div class="card-header with-border">Новый пароль</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'password')->passwordInput()->label('Новый пароль'); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'password2')->passwordInput()->label('Повторите пароль'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
