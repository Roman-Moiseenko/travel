<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \shop\forms\auth\SignupForm */

use booking\entities\Lang;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Lang::t('Регистрация');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Lang::t('Пожалуйста, заполните следующие поля для регистрации') ?>:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(Lang::t('Логин')) ?>
                <?= $form->field($model, 'email')->label(Lang::t('Электронная почта')) ?>
                <?= $form->field($model, 'password')->passwordInput()->label(Lang::t('Пароль')) ?>
                <div class="form-group">
                    <?= Html::submitButton(Lang::t('Зарегистрироваться'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
