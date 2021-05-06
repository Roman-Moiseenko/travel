<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model \booking\forms\auth\LoginForm */

use booking\entities\Lang;
use frontend\widgets\design\BtnLogin;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = Lang::t('Вход на сайт');

?>
<div class="site-login">


    <div class="row pt-4">
        <div class="col-sm-2 col-md-3 col-lg-4"></div>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <h3><?= Html::encode($this->title) ?></h3>
            <div class="card">
                <div class="card-body">
                    <div class="py-2">
                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'enableClientValidation' => false,
                        ]); ?>
                        <?= $form->field($model, 'username')
                            ->textInput(['autofocus' => true, 'placeholder' => Lang::t('Телефон или Email')])
                            ->label(false) ?>

                        <?= $form->field($model, 'password')
                            ->label(false)
                            ->widget(PasswordInput::class, [
                                'language' => 'ru',
                                'bsVersion' => 4,
                                'options' => ['placeholder' => Lang::t('Пароль')],
                                'pluginOptions' => [
                                    'showMeter' => false, // не обязательно, при следующем параметре:
                                    'mainTemplate' => '<table class="kv-strength-container"><tr><td>{input}</td></tr></table>',
                                ],
                            ]) ?>

                        <?= $form->field($model, 'rememberMe')->checkbox()->label(Lang::t('Запомнить меня')) ?>
                        <div class="form-group">
                            <?= BtnLogin::widget() ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <hr/>
                    <div class="py-2">
                        <?= yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['auth/network/auth']]); ?>
                        <p><?= Lang::t('* Не забудьте добавить email и телефон для информирования') ?></p>
                    </div>
                    <hr/>
                    <div class="d-flex" style="color:#999;margin:1em 0">
                        <div>
                        <?= Html::a(Lang::t('Восстановить пароль'), ['auth/reset/request']) ?>
                        </div>
                        <div class="ml-auto">
                        <?= Html::a(Lang::t('Регистрация'), ['/signup']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
