<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \booking\forms\admin\SignupForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-card-body">
    <p class="login-box-msg"><?= Html::encode($this->title) ?></p>
    <p><?= 'Пожалуйста, заполните следующие поля для регистрации:' ?></p>
    <div class="row">
        <div class="col">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>
            <?= $form->field($model, 'email')->label('Электронная почта') ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
            <?= $form->field($model, 'agreement')->checkbox()
                ->label(
                    'Настоящим я принимаю ' .
                    Html::a('Пользовательское соглашение',
                        Url::to(\Yii::$app->params['frontendHostInfo'] . '/agreement', true), ['target' => '_blank'])
                ) ?>
            <?= $form->field($model, 'offer')->checkbox()
                ->label(
                    'Настоящим я принимаю ' .
                    Html::a('Оферту для Провайдеров',
                        Url::to(\Yii::$app->params['frontendHostInfo'] . '/offer', true), ['target' => '_blank'])
                ) ?>
            <div class="form-group">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
