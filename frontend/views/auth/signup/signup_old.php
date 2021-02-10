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

//loginform-password
$js = <<<JS
/*
$('body').on('click', '.kodnaya-prokhod', function(){
      if ($('#loginform-password').attr('type') == 'password'){
      $(this).addClass('view');
      $('#loginform-password').attr('type', 'text');
  } else {
      $(this).removeClass('view');
      $('#loginform-password').attr('type', 'password');
  }
  return false;
});*/
JS;

$this->registerJs($js);
$this->title = Lang::t('Регистрация');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row pt-4">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <h1><?= Html::encode($this->title) ?></h1>
            <p><?= Lang::t('Пожалуйста, заполните следующие поля для регистрации') ?>:</p>
            <div class="row">
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(Lang::t('Логин')) ?>
                    <?= $form->field($model, 'email')->label(Lang::t('Электронная почта')) ?>
                    <?= $form->field($model, 'password')
                        ->passwordInput()
                        ->label(Lang::t('Пароль'))
                        ->widget(PasswordInput::class, [
                            'language' => 'ru',
                            'bsVersion' => 4,
                            'pluginOptions' => [
                                'showMeter' => false, // не обязательно, при следующем параметре:
                                'mainTemplate' => '<table class="kv-strength-container"><tr><td>{input}</td></tr></table>',
                            ],
                        ])
                        ->hint('Минимальная длина 6 символов') ?>
                    <?= $form->field($model, 'phone')->textInput()->label(Lang::t('Телефон'))
                    //->hint('Укажите номер телефона и получите скидку 5% на любое бронирование')
                    ?>

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
    </div>
    <div class="col-sm-2"></div>
</div>