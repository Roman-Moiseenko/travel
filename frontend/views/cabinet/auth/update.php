<?php


use booking\entities\Lang;
use booking\entities\user\User;
use booking\forms\admin\UserEditForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $model UserEditForm */
/* @var $user User */

$this->title = Lang::t('Изменить');
$this->params['breadcrumbs'][] = ['label' => Lang::t('Аутентификация'), 'url' => ['/cabinet/auth']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-update">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>


            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'username')->textInput()->label(Lang::t('логин')); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'email')->textInput()->label(Lang::t('Электронная почта')); ?>
                </div>
            </div>

<hr/>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'password')->passwordInput()->label(Lang::t('Новый пароль'))->hint(Lang::t('Оставьте пустым, если не хотите менять')); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'password2')->passwordInput()->label(Lang::t('Повторите пароль')); ?>
                </div>
            </div>

    <div class="form-group">
        <?= Html::submitButton(Lang::t('Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
