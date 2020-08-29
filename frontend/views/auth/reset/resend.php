<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model ResetPasswordForm */

use booking\entities\Lang;
use booking\forms\auth\ResetPasswordForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Resend verification email';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-resend-verification-email">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Lang::t('Пожалуйста, укажите свою электронную почту для отправки подтверждения пароля')?>.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton(Lang::t('Отправить'), ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
