<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \booking\forms\user\PasswordResetRequestForm */

use booking\entities\Lang;
use booking\forms\user\PasswordResetRequestForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = Lang::t('Сброс пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Lang::t('Пожалуйста, укажите свою электронную почту для отправки ссылки для сброса пароля')?>.</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton(Lang::t('Отправить'), ['class' => 'btn-lg btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
