<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model PasswordResetRequestForm */

use booking\forms\admin\PasswordResetRequestForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-card-body">
    <p class="login-box-msg"><?= Html::encode($this->title) ?></p>
    <p>Пожалуйста, укажите свою электронную почту для отправки ссылки для сброса пароля.</p>
    <div class="row">
        <div class="col">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
