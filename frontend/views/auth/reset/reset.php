<?php
use booking\entities\Lang;
use booking\forms\auth\ResetPasswordForm;
use frontend\widgets\design\BtnSave;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model ResetPasswordForm */


$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Lang::t('Пожалуйста, выберите новый пароль')?>:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
                <div class="form-group">
                    <?= BtnSave::widget() ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
