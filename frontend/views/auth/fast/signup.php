<?php

use booking\entities\Lang;
use booking\forms\auth\LoginForm;
use booking\forms\user\FastSignUpForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model FastSignUpForm */
$this->title = Lang::t('Быстрая регистрация');
?>

<div class="row pt-4">

    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <h1><?= $this->title ?></h1>
        <div class="card">
            <div class="card-body">
                <?php $form = ActiveForm::begin([]); ?>
                <div class="row">
                    <div class="col-sm-6">
                    <?= $form->field($model->signup, 'username')->textInput(['autofocus' => true])->label(Lang::t('Логин')) ?>
                    <?= $form->field($model->signup, 'email')->label(Lang::t('Электронная почта')) ?>
                    <?= $form->field($model->signup, 'password')->passwordInput()->label(Lang::t('Пароль')) ?>
                    </div>
                    <div class="col-sm-6">
                    <?= $form->field($model->fullname, 'surname')->textInput()->label(Lang::t('Фамилия')); ?>
                    <?= $form->field($model->fullname, 'firstname')->textInput()->label(Lang::t('Имя')); ?>
                    <?= $form->field($model->fullname, 'secondname')->textInput()->label(Lang::t('Отчество')); ?>
                    <?= $form->field($model, 'phone')->textInput()->label(Lang::t('Телефон')); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                    <?= $form->field($model->signup, 'agreement')->checkbox()
                        ->label(
                            Lang::t('Настоящим я принимаю') . ' ' . Html::a(Lang::t('Пользовательское соглашение'), Url::to(['/agreement']), ['target' => '_blank'])
                        ) ?>
                    <?= $form->field($model, 'agreement')->checkbox()
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
        Если у вас уже есть логин, то Вы можете <a href="<?= Url::to(['/login']) ?>">войти под ним</a>
    </div>
    <div class="col-sm-2"></div>
</div>
