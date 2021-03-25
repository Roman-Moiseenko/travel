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
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <h1><?= Lang::t('Регистрация'); ?></h1>
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin([]); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(Lang::t('Логин')) ?>
                            <?= $form->field($model, 'email')->label(Lang::t('Электронная почта')) ?>
                            <?= $form->field($model, 'password')
                                ->passwordInput()
                                ->label(Lang::t('Пароль'))
                                ->widget(PasswordInput::class, [
                                    'language' => 'ru',
                                    'bsVersion' => 4,
                                    'pluginOptions' => [
                                        'showMeter' =>false, // не обязательно, при следующем параметре:
                                        'mainTemplate' => '<table class="kv-strength-container"><tr><td>{input}</td></tr></table>',
                                    ],
                                ])
                                ->hint('Минимальная длина 6 символов') ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'surname')->textInput()->label(Lang::t('Фамилия')); ?>
                            <?= $form->field($model, 'firstname')->textInput()->label(Lang::t('Имя')); ?>
                            <?= $form->field($model, 'secondname')->textInput()->label(Lang::t('Отчество')); ?>
                            <?= $form->field($model, 'phone')->textInput()->label(Lang::t('Телефон'))->hint(Lang::t('Код страны + 10 цифр без пробелов и символов: +70001112222')); ?>
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
            <?= Lang::t('Если Вы уже зарегистрированы, то войдите') ?> <a href="<?= Url::to(['/login']) ?>"><?= Lang::t('в личный кабинет')?></a>
        </div>

    </div>
    <div class="col-sm-2"></div>
</div>