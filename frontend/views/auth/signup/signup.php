<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model \booking\forms\user\SignupForm */

use booking\entities\Lang;
use booking\forms\user\SignupForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

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
            <?= $form->field($model, 'agreement')->checkbox()
                ->label(
                    Lang::t('Настоящим я принимаю') . ' ' . Html::a(Lang::t('Пользовательское соглашение'), Url::to(['/agreement']), ['target' => '_blank'])
                ) ?>
            <div class="form-group">
                <?= Html::submitButton(Lang::t('Зарегистрироваться'), ['class' => 'btn-lg btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
