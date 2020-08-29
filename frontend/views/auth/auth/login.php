<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \shop\forms\auth\LoginForm */

use booking\entities\Lang;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Lang::t('Вход в личный кабинет');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Lang::t('Пожалуйста, заполните следующие поля для входа в систему') ?>:</p>

    <div class="row">
        <div class="col-sm-6">
            <div class="well">
                <h2><?= Lang::t('Новый пользователь') ?></h2>
                <p><strong><?= Lang::t('Зарегистрировать аккаунт') ?></strong></p>
                <p><?= Lang::t('Создав учетную запись, вы сможете бронировать, быть в курсе состояния брони и
                    отслеживать ранее сделанные брони') ?>.</p>
                <a href="/signup" class="btn btn-primary"><?= Lang::t('Продолжить') ?></a>
            </div>
            <div class="well">
                <p><strong><?= Lang::t('Войти через социальные сети') ?></strong></p>
                <p><?= Lang::t('Зарегистрировавшись через социальные сети, не забудьте добавить email и телефон для оповещения о статусе Ваших броней')?>.</p>
                <?= yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['auth/network/auth']]); ?></div>
        </div>
        <div class="col-sm-6">
            <div class="well">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(Lang::t('Логин')) ?>
                <?= $form->field($model, 'password')->passwordInput()->label(Lang::t('Пароль')) ?>
                <?= $form->field($model, 'rememberMe')->checkbox()->label(Lang::t('Запомнить меня')) ?>
                <div style="color:#999;margin:1em 0">
                    <?= Lang::t('Если Вы забыли пароль, то вы можете') ?> <?= Html::a(Lang::t('сбросить его'), ['auth/reset/request']) ?>
                    .
                    <br>
                    <?= Lang::t('Необходимо подтверждение почты?') ?> <?= Html::a(Lang::t('Отправить'), ['auth/reset/resend']) ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton(Lang::t('Войти'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
