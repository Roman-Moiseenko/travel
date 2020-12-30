<?php

use booking\forms\auth\LoginForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model LoginForm */

$this->title = 'Войти в систему';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-card">
    <!-- /.login-logo -->
    <div class="login-card-body">
        <p class="login-box-msg"></p>
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => 'Логин']) ?>
        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => 'Пароль']) ?>
        <div class="row">
            <div class="col-sm-8">
                <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить') ?>
            </div>
            <div class="col-sm-4">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <a href="<?= Url::to(['/auth/reset/request'])?>">Забыли пароль?</a><br>
        <a href="<?= Url::to(['/signup'])?>" class="text-center">Регистрация</a>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
