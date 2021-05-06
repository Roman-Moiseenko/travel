<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model ResetPasswordForm */

use booking\entities\Lang;
use booking\forms\auth\ResetPasswordForm;
use frontend\widgets\design\BtnSend;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

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
                <?= BtnSend::widget(['caption' => 'Отправить']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
