<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model \booking\forms\user\SignupForm */

use booking\entities\Lang;
use booking\forms\user\SignupForm;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = Lang::t('Регистрация на портале туристических услуг');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row pt-4">
        <div class="col-sm-2 col-md-3 col-lg-4"></div>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <h3><?= Lang::t('Регистрация'); ?></h3>
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'enableClientValidation' => false,
                    ]); ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'firstname')->textInput(['placeholder' => Lang::t('Имя')])->label(false); ?>
                            <?= $form->field($model, 'surname')->textInput(['placeholder' => Lang::t('Фамилия')])->label(false); ?>
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => Lang::t('Телефон *')])->label(false)->hint(Lang::t('* 10 цифр без символов: +70001112222')); ?>

                            <?= $form->field($model, 'email')->textInput(['placeholder' => Lang::t('Электронная почта')])->label(false) ?>
                            <?= $form->field($model, 'password')
                                ->label(false)
                                ->widget(PasswordInput::class, [
                                    'language' => 'ru',
                                    'bsVersion' => 4,
                                    'options' => ['placeholder' => Lang::t('Пароль')],
                                    'pluginOptions' => [
                                        'showMeter' =>false, // не обязательно, при следующем параметре:
                                        'mainTemplate' => '<table class="kv-strength-container"><tr><td>{input}</td></tr></table>',
                                    ],
                                ])
                                ->hint('Минимальная длина 6 символов') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $form->field($model, 'agreement')->checkbox()
                                ->label(
                                    Lang::t('Настоящим я принимаю') . ' ' . Html::a(Lang::t('Пользовательское соглашение'), Url::to(['/agreement']), ['target' => '_blank'])
                                ) ?>
                            <?= $form->field($model, 'policy')->checkbox()
                                ->label(Lang::t('Согласие на обработку Персональных данных'))
                                ->hint(
                                    Lang::t('Подтверждая данный выбор, я принимаю ') .
                                    Html::a(Lang::t('Политику конфиденциальности'), Url::to(['/policy']), ['target' => '_blank'])
                                ); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton(Lang::t('Зарегистрироваться'), ['class' => 'btn-lg btn-primary', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <a href="<?= Url::to(['/login']) ?>"><?= Lang::t('Войти в личный кабинет')?></a>
        </div>
    </div>
    <div class="col-sm-2"></div>
</div>